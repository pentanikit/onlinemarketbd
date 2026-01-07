<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopAddress extends Model
{
    protected $fillable = [
        'shop_id',
        'division',
        'district',
        'address',
        'postal_code',
        'pickup_notes',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
