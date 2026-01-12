<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\SellerProducts;

class ShopController extends Controller
{
    public function show($slug)
    {
        $shop = Shop::where('slug', $slug)->firstOrFail();

        $ads = SellerProducts::where('shop_id', $shop->id)
            ->when(request('q'), function($q){
                $s = trim((string)request('q'));
                $q->where('name','like',"%{$s}%");
            })
            ->with('primaryImage')
            ->latest()
            ->paginate(10);

        return view('seller.view', compact('shop', 'ads'));
    }
}
