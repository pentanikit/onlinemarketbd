<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Str;


class SiteContentController extends Controller
{
    // Edit homepage content
    public function editHome()
    {
        $content = SiteContent::firstOrCreate(
            ['key' => 'home'],
            [
                'about_title'   => 'About Us',
                'manage_title'  => 'Manage your free listing.',
                'mission_title' => 'Our Mission',
                'vision_title'  => 'Our Vision',
            ]
        );

        return view('backend.site_content.home-content-edit', compact('content'));
    }

    // Update homepage content (partial updates supported)
public function updateHome(Request $request)
{
    dd($request->all());
    // =========================
    // Dedicated file logger (works even if laravel.log isn't being created)
    // =========================
    $rid = (string) Str::uuid();

    $fileLogger = Log::build([
        'driver' => 'single',
        'path'   => storage_path('logs/home_upload.log'),
        'level'  => 'debug',
    ]);

    $fileLogger->info('HOME UPDATE START', [
        'rid' => $rid,
        'url' => $request->fullUrl(),
        'ip'  => $request->ip(),
        'user_id' => optional($request->user())->id,
        'content_type' => $request->header('Content-Type'),
        'content_length' => $request->header('Content-Length'),
    ]);

    // Check public disk path + permissions
    try {
        $publicRoot = Storage::disk('public')->path('');
        $fileLogger->info('PUBLIC DISK CHECK', [
            'rid' => $rid,
            'public_root' => $publicRoot,
            'root_exists' => is_dir($publicRoot),
            'root_writable' => is_writable($publicRoot),
            'storage_app_public_exists' => is_dir(storage_path('app/public')),
            'storage_app_public_writable' => is_writable(storage_path('app/public')),
        ]);
    } catch (\Throwable $e) {
        $fileLogger->error('PUBLIC DISK CHECK FAILED', [
            'rid' => $rid,
            'err' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ]);
    }

    // Log which files Laravel thinks it received
    $fieldsToCheck = ['logo_image','hero_image','manage_image','mission_image','vision_image'];
    foreach ($fieldsToCheck as $f) {
        try {
            $has = $request->hasFile($f);
            $file = $has ? $request->file($f) : null;

            $fileLogger->info('FILE CHECK', [
                'rid' => $rid,
                'field' => $f,
                'hasFile' => $has,
                'isValid' => $file ? $file->isValid() : null,
                'origName' => $file ? $file->getClientOriginalName() : null,
                'mime' => $file ? $file->getClientMimeType() : null,
                'size_bytes' => $file ? $file->getSize() : null,
                'tmp_path' => $file ? $file->getPathname() : null,
            ]);
        } catch (\Throwable $e) {
            $fileLogger->error('FILE CHECK FAILED', [
                'rid' => $rid,
                'field' => $f,
                'err' => $e->getMessage(),
            ]);
        }
    }

    $content = SiteContent::firstOrCreate(['key' => 'home']);

    $validated = $request->validate([
        'about_title'   => 'nullable|string|max:255',
        'about_body'    => 'nullable|string',
        'hero_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        'logo_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        'manage_title'     => 'nullable|string|max:255',
        'manage_body'      => 'nullable|string',
        'manage_cta_text'  => 'nullable|string|max:255',
        'manage_cta_url'   => 'nullable|string|max:255',
        'manage_phone'     => 'nullable|string|max:50',
        'manage_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

        'mission_title' => 'nullable|string|max:255',
        'mission_body'  => 'nullable|string',
        'mission_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

        'vision_title'  => 'nullable|string|max:255',
        'vision_body'   => 'nullable|string',
        'vision_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',

        'meta'          => 'nullable|array',
    ]);

    try {
        DB::transaction(function () use ($request, $content, $validated, $fileLogger, $rid) {

            // Remove file fields from mass-fill (we handle manually)
            unset(
                $validated['manage_image'],
                $validated['mission_image'],
                $validated['vision_image'],
                $validated['hero_image'],
                $validated['logo_image']
            );

            $content->fill($validated);

            $upload = function (string $field, string $dbColumn) use ($request, $content, $fileLogger, $rid) {
                if (!$request->hasFile($field)) {
                    $fileLogger->info('UPLOAD SKIP (no file)', ['rid' => $rid, 'field' => $field]);
                    return;
                }

                $file = $request->file($field);

                if (!$file || !$file->isValid()) {
                    $fileLogger->warning('UPLOAD INVALID FILE', [
                        'rid' => $rid,
                        'field' => $field,
                        'origName' => $file ? $file->getClientOriginalName() : null,
                        'error' => $file ? $file->getError() : null,
                        'errorMessage' => $file ? $file->getErrorMessage() : null,
                    ]);
                    return;
                }

                try {
                    // delete old
                    $old = $content->{$dbColumn};
                    $fileLogger->info('UPLOAD OLD CHECK', [
                        'rid' => $rid,
                        'field' => $field,
                        'dbColumn' => $dbColumn,
                        'old' => $old,
                        'old_exists' => $old ? Storage::disk('public')->exists($old) : null,
                        'public_root_writable' => is_writable(Storage::disk('public')->path('')),
                    ]);

                    if ($old && Storage::disk('public')->exists($old)) {
                        Storage::disk('public')->delete($old);
                        $fileLogger->info('UPLOAD OLD DELETED', ['rid' => $rid, 'field' => $field, 'old' => $old]);
                    }

                    $fileLogger->info('UPLOAD STORE START', [
                        'rid' => $rid,
                        'field' => $field,
                        'origName' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                        'size_bytes' => $file->getSize(),
                    ]);

                    // store new
                    $path = $file->store('site/home', 'public');

                    $fileLogger->info('UPLOAD STORE DONE', [
                        'rid' => $rid,
                        'field' => $field,
                        'stored_path' => $path,
                        'stored_exists' => $path ? Storage::disk('public')->exists($path) : null,
                        'stored_fullpath' => $path ? Storage::disk('public')->path($path) : null,
                    ]);

                    $content->{$dbColumn} = $path;

                } catch (\Throwable $e) {
                    $fileLogger->error('UPLOAD FAILED', [
                        'rid' => $rid,
                        'field' => $field,
                        'dbColumn' => $dbColumn,
                        'err' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => substr($e->getTraceAsString(), 0, 4000),
                    ]);
                    throw $e; // rethrow so transaction can roll back
                }
            };

            $upload('logo_image', 'logo_image');
            $upload('hero_image', 'hero_image');
            $upload('manage_image',  'manage_image');
            $upload('mission_image', 'mission_image');
            $upload('vision_image',  'vision_image');

            $content->save();

            $fileLogger->info('DB SAVE OK', [
                'rid' => $rid,
                'content_id' => $content->id,
            ]);
        });

        $fileLogger->info('HOME UPDATE SUCCESS', ['rid' => $rid]);

        return back()->with('success', 'Homepage content updated successfully.');

    } catch (\Throwable $e) {
        $fileLogger->error('HOME UPDATE ERROR (outer)', [
            'rid' => $rid,
            'err' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => substr($e->getTraceAsString(), 0, 4000),
        ]);

        return back()->with('error', 'Upload failed. Check logs: storage/logs/home_upload.log (RID: '.$rid.')');
    }
}

}

