<?php

namespace App\Modules\Classifieds\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassifiedAd extends Model
{
    protected $table = 'classified_ads';

    protected $fillable = [
        'classified_ad_user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'price',
        'price_type',
        'condition_type',
        'location',
        'contact_name',
        'contact_email',
        'contact_phone',
        'status',
        'published_at',
        'expires_at',
        'views_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $ad) {
            if (empty($ad->slug)) {
                $ad->slug = Str::slug($ad->title) . '-' . strtolower(Str::random(6));
            }
        });
    }

    public function adUser(): BelongsTo
    {
        return $this->belongsTo(ClassifiedAdUser::class, 'classified_ad_user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ClassifiedCategory::class, 'category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ClassifiedAdImage::class, 'classified_ad_id')->orderBy('sort_order');
    }

    public function primaryImage(): HasMany
    {
        return $this->hasMany(ClassifiedAdImage::class, 'classified_ad_id')
            ->where('is_primary', 1)
            ->limit(1);
    }
}