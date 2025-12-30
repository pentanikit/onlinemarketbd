<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteContent extends Model
{
    protected $fillable = [
        'key',

        'about_title','about_body',

        'hero_image', 'logo_image',

        'manage_title','manage_body','manage_cta_text','manage_cta_url','manage_phone','manage_image',

        'mission_title','mission_body','mission_image',

        'vision_title','vision_body','vision_image',


        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    // Optional: nice URL helpers for Blade
    public function imageUrl(?string $path): ?string
    {
        return $path ? Storage::disk('public')->url($path) : null;
    }

    public function getManageImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->manage_image);
    }

    public function getMissionImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->mission_image);
    }

    public function getVisionImageUrlAttribute(): ?string
    {
        return $this->imageUrl($this->vision_image);
    }
}
