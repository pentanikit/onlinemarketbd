<?php

namespace App\Modules\Classifieds\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Modules\Classifieds\Models\ClassifiedAd;
use App\Modules\Classifieds\Models\ClassifiedAdUser;
use App\Modules\Classifieds\Models\ClassifiedCategory;
use App\Modules\Classifieds\Models\ClassifiedAdImage;

class ClassifiedOnboardingService
{
    public function createAdWithUser(array $data, ClassifiedCategory $category): ClassifiedAd
    {
        return DB::transaction(function () use ($data, $category) {
            $user = $this->resolveUser($data);

            $ad = ClassifiedAd::create([
                'classified_ad_user_id' => $user->id,
                'category_id' => $category->id,
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'price' => $data['price'] ?? null,
                'price_type' => $data['price_type'] ?? 'fixed',
                'condition_type' => $data['condition_type'] ?? null,
                'location' => $data['location'] ?? null,
                'contact_name' => $data['name'],
                'contact_email' => $data['email'] ?? null,
                'contact_phone' => $data['phone'],
                'status' => config('classifieds.default_status', 'pending'),
                'published_at' => config('classifieds.default_status', 'pending') === 'published' ? now() : null,
                'expires_at' => now()->addDays(30),
            ]);

            if (!empty($data['images'])) {
                foreach ($data['images'] as $index => $image) {
                    $path = $image->store(
                        config('classifieds.image_directory', 'classifieds/ads'),
                        config('classifieds.image_disk', 'public')
                    );

                    ClassifiedAdImage::create([
                        'classified_ad_id' => $ad->id,
                        'image_path' => $path,
                        'is_primary' => $index === 0,
                        'sort_order' => $index + 1,
                    ]);
                }
            }

            session([
                config('classifieds.session_key', 'classified_ad_user_id') => $user->id
            ]);

            return $ad->load(['images', 'category', 'adUser']);
        });
    }

    protected function resolveUser(array $data): ClassifiedAdUser
    {
        $user = ClassifiedAdUser::query()
            ->when(!empty($data['email']), function ($q) use ($data) {
                $q->orWhere('email', $data['email']);
            })
            ->orWhere('phone', $data['phone'])
            ->first();

        if ($user) {
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'] ?? $user->email,
                'last_login_at' => now(),
            ]);

            return $user;
        }

        return ClassifiedAdUser::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'],
            'password' => Hash::make(Str::random(16)),
            'status' => 'active',
            'last_login_at' => now(),
        ]);
    }
}