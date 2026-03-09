<?php

namespace App\Modules\Classifieds\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassifiedAdUser extends Model
{
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
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    public function ads(): HasMany
    {
        return $this->hasMany(ClassifiedAd::class, 'classified_ad_user_id');
    }
}