<?php

namespace App\View\Components\Frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Cache;
use App\Models\Category as Cat;

class Category extends Component
{
    /**
     * Create a new component instance.
     */
    public $categories;
    public function __construct()
    {
            $this->categories = Cache::rememberForever('top_categories_v1', function () {
                return Cat::whereNull('parent_id')
                    ->orderBy('sort_order')
                    ->get();
            });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.frontend.category');
    }
}
