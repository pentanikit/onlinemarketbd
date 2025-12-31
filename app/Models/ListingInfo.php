<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingInfo extends Model
{
    protected $fillable = [
        'listing_id',
        'tagline',
        'about',
        'fax',
        'services',
        'social_profiles',
        'other_emails',
        'other_phones',
        'payment_methods',
        'accreditations',
    ];

    protected $casts = [
        'services'        => 'array',
        'social_profiles' => 'array',
        'other_emails'    => 'array',
        'other_phones'    => 'array',
        'payment_methods' => 'array',
        'accreditations'  => 'array',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
