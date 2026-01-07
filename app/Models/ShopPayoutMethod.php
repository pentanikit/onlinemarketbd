<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShopPayoutMethod extends Model
{
    protected $fillable = [
        'shop_id',
        'method',
        'account_number',
        'account_name',
        'bank_info',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
}
