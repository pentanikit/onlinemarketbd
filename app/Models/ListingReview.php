<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingReview extends Model
{
    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'listing_id',
        'name',
        'rating',
        'comment',
        'status',
        'approved_at',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'rating'      => 'integer',
        'approved_at' => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    protected static function booted(): void
    {
        // Keep listing avg_rating + review_count in sync automatically
        static::saved(function (self $review) {
            $review->syncListingRating();
        });

        static::deleted(function (self $review) {
            $review->syncListingRating();
        });
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    protected function syncListingRating(): void
    {
        // Only update if listing exists
        $listing = $this->listing()->first();
        if (!$listing) return;

        $q = $listing->reviews()->approved();

        $count = (int) $q->count();
        $avg   = $count > 0 ? round((float) $q->avg('rating'), 1) : 0;

        $listing->forceFill([
            'avg_rating'   => $avg,
            'review_count' => $count,
        ])->saveQuietly();
    }
}
