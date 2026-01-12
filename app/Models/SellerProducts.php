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

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id', 'id');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImages::class, 'product_id', 'id')->where('is_primary', 1);
    }
}
