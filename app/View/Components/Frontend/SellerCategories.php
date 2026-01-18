<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\SellerCategory;
use Illuminate\Support\Facades\Cache;

class SellerCategories extends Component
{
    /**
     * Create a new component instance.
     */
    public $sellercategories;

    public function __construct()
    {
        $this->sellercategories =  SellerCategory::whereNull('parent_id')
                    ->orderBy('sort_order')
                    ->get();
           
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.shop-category');
    }
}
