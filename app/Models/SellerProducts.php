<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SellerProducts extends Model
{
    protected $fillable = [
        'shop_id','seller_id','name','slug','sku',
        'price','compare_price','cost_price','currency',
        'stock_qty','track_stock','allow_backorder',
        'short_description','description',
        'attributes','variants','shipping',
        'status','seo_title','seo_description'
    ];

    protected $casts = [
        'track_stock' => 'boolean',
        'allow_backorder' => 'boolean',
        

    ];


    public function category()
    {
        return $this->belongsTo(SellerCategory::class, 'seller_category_id');
    }

    // Useful: direct parent category (if selected category is a subcategory)
    public function parentCategory()
    {
        return $this->hasOneThrough(
            SellerCategory::class,
            SellerCategory::class,
            'id',        // through: seller_categories.id
            'id',        // parent: seller_categories.id
            'seller_category_id', // local key on products
            'parent_id'  // key on through (selected category -> parent_id)
        );
    }


    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id', 'id')->where('is_primary', 1);
    }
}
