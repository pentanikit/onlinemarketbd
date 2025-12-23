<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingPhotos extends Model
{
    protected $fillable = [
        'listing_id',
        'path',
        'alt_text',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
