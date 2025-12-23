<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingOwner extends Model
{
    protected $fillable = [
        'listing_id',
        'owner_name',
        'nid_number',
        'nid_front_path',
        'nid_back_path',
        'trade_license_path',
        'tax_document_path',
        'verification_status',
        'verified_at',
        'review_notes',
        'agreed_terms',
        'agreed_at',
    ];

    protected $casts = [
        'agreed_terms' => 'boolean',
        'verified_at'  => 'datetime',
        'agreed_at'    => 'datetime',
    ];

    public function listing()
    {
        return $this->belongsTo(Listing::class);
    }
}
