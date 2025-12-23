<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingAddress extends Model
{
    protected $fillable = [
        'listing_id',
        'country_code',
        'city_id',
        'city_name',
        'area',
        'line1',
        'line2',
        'postal_code',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
