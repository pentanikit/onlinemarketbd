<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SellerCategory extends Model
{
    protected $table = 'seller_categories';

    protected $fillable = [
        'shop_id',
        'seller_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'icon',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    // Auto slug if not provided
    protected static function booted()
    {
        static::saving(function (SellerCategory $cat) {
            if (empty($cat->slug)) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(SellerCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(SellerCategory::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    public function products()
    {
        return $this->hasMany(SellerProducts::class, 'seller_category_id', 'id');
    }

    // Helper: top-level only
    public function scopeParents($q)
    {
        return $q->whereNull('parent_id');
    }

    // Helper: subcategories only
    public function scopeChildrenOnly($q)
    {
        return $q->whereNotNull('parent_id');
    }
}

