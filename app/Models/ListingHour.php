<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingHour extends Model
{
    protected $fillable = [
        'listing_id',
        'day_of_week',
        'opens_at',
        'closes_at',
        'is_closed',
        'is_24_hours',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_closed'   => 'boolean',
        'is_24_hours' => 'boolean',
        'opens_at'    => 'datetime:H:i',
        'closes_at'   => 'datetime:H:i',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Simple helper: human-readable day name (0=Sun..6=Sat)
     */
    public function getDayNameAttribute(): string
    {
        $map = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return $map[$this->day_of_week] ?? 'Unknown';
    }

    /**
     * Helper: formatted range "10:00 AM – 10:00 PM" / "Closed"
     */
    public function getFormattedRangeAttribute(): string
    {
        if ($this->is_24_hours) {
            return 'Open 24 hours';
        }

        if ($this->is_closed || !$this->opens_at || !$this->closes_at) {
            return 'Closed';
        }

        // opens_at & closes_at are cast to Carbon via casts above
        return $this->opens_at->format('g:i A') . ' – ' . $this->closes_at->format('g:i A');
    }
}

