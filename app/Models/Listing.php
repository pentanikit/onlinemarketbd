<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = [
        'user_id',
        'tracking_id',
        'category_id',
        'city_id',
        'name',
        'slug',
        'type',
        'tagline',
        'description',
        'email',
        'phone',
        'website',
        'price_level',
        'highlights',
        'lat',
        'lng',
        'is_claimed',
        'status',
        'avg_rating',
        'review_count',
        'meta',
    ];

    protected $casts = [
        'is_claimed'   => 'boolean',
        'price_level'  => 'integer',
        'avg_rating'   => 'float',
        'review_count' => 'integer',
        'meta'         => 'array',
    ];

    /* Relationships */

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function address()
    {
        return $this->hasOne(ListingAddress::class);
    }

    public function hours()
    {
        return $this->hasMany(ListingHour::class);
    }

    public function photos()
    {
        return $this->hasMany(ListingPhotos::class)->orderBy('sort_order');
    }

    public function primaryPhoto()
    {
        return $this->hasOne(ListingPhotos::class)->where('is_primary', true);
    }

    public function ownerVerification()
    {
        return $this->hasOne(ListingOwner::class);
    }

    /* Common scopes */

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForCityCategory($query, $cityId, $categoryId = null)
    {
        $query->where('city_id', $cityId);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        return $query->where('status', 'active');
    }
}
