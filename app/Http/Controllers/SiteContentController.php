<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SiteContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $content = SiteContent::firstOrCreate(['key' => 'home']);

        $validated = $request->validate([
            'about_title'   => 'nullable|string|max:255',
            'about_body'    => 'nullable|string',
            'hero_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'logo_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'manage_title'     => 'nullable|string|max:255',
            'manage_body'      => 'nullable|string',
            'manage_cta_text'  => 'nullable|string|max:255',
            'manage_cta_url'   => 'nullable|string|max:255', // keep string to allow internal routes too
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

        DB::transaction(function () use ($request, $content, $validated) {

            // Remove file fields from mass-fill (we handle manually)
            unset($validated['manage_image'], $validated['mission_image'], $validated['vision_image'], $validated['hero_image'], $validated['logo_image']);

            $content->fill($validated);

            // Upload helpers
            $upload = function (string $field, string $dbColumn) use ($request, $content) {
                if (!$request->hasFile($field)) return;

                // delete old
                $old = $content->{$dbColumn};
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }

                // store new
                $path = $request->file($field)->store('site/home', 'public');
                $content->{$dbColumn} = $path;
            };

            $upload('logo_image', 'logo_image');
            $upload('hero_image', 'hero_image');
            $upload('manage_image',  'manage_image');
            $upload('mission_image', 'mission_image');
            $upload('vision_image',  'vision_image');

            $content->save();
        });

        return back()->with('success', 'Homepage content updated successfully.');
    }
}

