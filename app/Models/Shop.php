<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Shop extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'category',
        'slug',
        'support_phone',
        'description',
        'logo_path',
        'banner_path',
        'status',
        'onboarded_at',
    ];

    protected $casts = [
        'onboarded_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(ShopAddress::class, 'shop_id');
    }

    public function payout(): HasOne
    {
        return $this->hasOne(ShopPayoutMethod::class, 'shop_id')->where('is_default', true);
    }
}
