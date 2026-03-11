<?php

namespace App\Modules\Classifieds\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ClassifiedAdUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'classified_ad_users';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    public function ads(): HasMany
    {
        return $this->hasMany(ClassifiedAd::class, 'classified_ad_user_id');
    }

    public function shop(): HasOne
    {
        return $this->hasOne(\App\Models\Shop::class, 'classified_ad_user_id');
    }
}