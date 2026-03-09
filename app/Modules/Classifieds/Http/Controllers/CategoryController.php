<?php

namespace App\Modules\Classifieds\Http\Controllers;

use Illuminate\Routing\Controller;
use App\Modules\Classifieds\Models\ClassifiedCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ClassifiedCategory::query()
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('classifieds::categories.index', compact('categories'));
    }
}