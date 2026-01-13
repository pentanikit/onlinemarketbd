<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\SellerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerCategoryController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = auth()->id();
        $shopId   = auth()->user()->shop_id ?? null;

        $q = SellerCategory::query()
            ->where(function($qq) use ($sellerId, $shopId) {
                // Scope categories to seller/shop if you store these
                if ($shopId !== null) $qq->where('shop_id', $shopId);
                $qq->where('seller_id', $sellerId);
            })
            ->withCount('children')
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($request->filled('search')) {
            $s = trim((string) $request->search);
            $q->where(function($qq) use ($s){
                $qq->where('name', 'like', "%{$s}%")
                   ->orWhere('slug', 'like', "%{$s}%");
            });
        }

        $categories = $q->paginate(30);

        return view('seller.categories.index', compact('categories'));
    }

    public function create()
    {
        $sellerId = auth()->id();
        $shopId   = auth()->user()->shop_id ?? null;

        $parents = SellerCategory::query()
            ->whereNull('parent_id')
            ->where(function($qq) use ($sellerId, $shopId) {
                if ($shopId !== null) $qq->where('shop_id', $shopId);
                $qq->where('seller_id', $sellerId);
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('seller.categories.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $sellerId = auth()->id();
        $shopId   = auth()->user()->shop_id ?? null;

        $data = $request->validate([
            'name'        => ['required','string','max:190'],
            'slug'        => ['nullable','string','max:190'],
            'parent_id'   => ['nullable','integer','exists:seller_categories,id'],
            'description' => ['nullable','string'],
            'icon'        => ['nullable','string','max:255'],
            'sort_order'  => ['nullable','integer','min:0'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $data['seller_id'] = $sellerId;
        $data['shop_id']   = $shopId;

        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['name']);

        // Ensure unique slug within seller+shop
        $base = $data['slug'];
        $i = 1;
        while (SellerCategory::where('seller_id', $sellerId)
            ->when($shopId !== null, fn($q) => $q->where('shop_id', $shopId))
            ->where('slug', $data['slug'])
            ->exists()
        ) {
            $data['slug'] = $base.'-'.$i++;
        }

        SellerCategory::create($data);

        return redirect()->route('seller.categories.index')->with('success', 'Category saved.');
    }

    public function edit(SellerCategory $category)
    {
        $this->authorizeCategory($category);

        $sellerId = auth()->id();
        $shopId   = auth()->user()->shop_id ?? null;

        $parents = SellerCategory::query()
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->where(function($qq) use ($sellerId, $shopId) {
                if ($shopId !== null) $qq->where('shop_id', $shopId);
                $qq->where('seller_id', $sellerId);
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('seller.categories.edit', compact('category','parents'));
    }

    public function update(Request $request, SellerCategory $category)
    {
        $this->authorizeCategory($category);

        $sellerId = auth()->id();
        $shopId   = auth()->user()->shop_id ?? null;

        $data = $request->validate([
            'name'        => ['required','string','max:190'],
            'slug'        => ['nullable','string','max:190'],
            'parent_id'   => ['nullable','integer','exists:seller_categories,id'],
            'description' => ['nullable','string'],
            'icon'        => ['nullable','string','max:255'],
            'sort_order'  => ['nullable','integer','min:0'],
            'is_active'   => ['nullable','boolean'],
        ]);

        $data['slug'] = $data['slug'] ? Str::slug($data['slug']) : Str::slug($data['name']);

        // Unique slug check (exclude current)
        $base = $data['slug'];
        $i = 1;
        while (SellerCategory::where('seller_id', $sellerId)
            ->when($shopId !== null, fn($q) => $q->where('shop_id', $shopId))
            ->where('slug', $data['slug'])
            ->where('id','!=',$category->id)
            ->exists()
        ) {
            $data['slug'] = $base.'-'.$i++;
        }

        $category->update($data);

        return redirect()->route('seller.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(SellerCategory $category)
    {
        $this->authorizeCategory($category);

        // This will null product.seller_category_id via FK nullOnDelete()
        $category->delete();

        return redirect()->route('seller.categories.index')->with('success', 'Category deleted.');
    }

    // ✅ AJAX: get subcategories by parent_id
    public function children(Request $request)
    {
        $sellerId = auth()->id();
        $shopId   = auth()->user()->shop_id ?? null;

        $parentId = (int) $request->get('parent_id', 0);

        $children = SellerCategory::query()
            ->where('parent_id', $parentId)
            ->where(function($qq) use ($sellerId, $shopId) {
                if ($shopId !== null) $qq->where('shop_id', $shopId);
                $qq->where('seller_id', $sellerId);
            })
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name','slug','parent_id']);

        return response()->json(['data' => $children]);
    }

    private function authorizeCategory(SellerCategory $category): void
    {
        $sellerId = auth()->id();
        $shopId   = auth()->user()->shop_id ?? null;

        if ((int)$category->seller_id !== (int)$sellerId) abort(403);

        if ($shopId !== null && (int)$category->shop_id !== (int)$shopId) abort(403);
    }
}

