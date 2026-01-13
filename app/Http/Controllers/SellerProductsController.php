<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerProducts as Product;
use App\Models\ProductImages as ProductImage;
use App\Models\Shop;

use App\Models\SellerCategory; // ✅ NEW

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductsController extends Controller
{
    public function create()
    {
        $shop = $this->sellerShop();

        // ✅ NEW: Parent categories for dropdown
        $parentCategories = SellerCategory::query()
            ->where('shop_id', (int) $shop->id)
            ->where('seller_id', (int) auth()->id())
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name','slug']);

        return view('seller.products.create', compact('shop', 'parentCategories'));
    }

    /**
     * ✅ NEW: AJAX endpoint to fetch subcategories by parent_id
     * Route example:
     *   Route::get('/seller/categories/children', [SellerProductsController::class, 'categoryChildren'])
     *      ->name('seller.categories.children');
     */
    public function categoryChildren(Request $request)
    {
        $shop = $this->sellerShop();

        $parentId = (int) $request->get('parent_id', 0);

        $children = SellerCategory::query()
            ->where('shop_id', (int) $shop->id)
            ->where('seller_id', (int) auth()->id())
            ->where('parent_id', $parentId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name','slug','parent_id']);

        return response()->json(['data' => $children]);
    }

    public function store(Request $request)
    {
        $shop = $this->sellerShop();

        $data = $request->validate([
            'name' => ['required','string','max:180'],
            'sku' => ['nullable','string','max:80'],

            // ✅ NEW: Category inputs (parent + subcategory)
            // You can submit either:
            // - seller_category_id (subcategory id) OR
            // - parent_category_id (only parent if no subcategories)
            'parent_category_id' => ['nullable','integer','exists:seller_categories,id'],
            'seller_category_id' => ['nullable','integer','exists:seller_categories,id'],

            'price' => ['required','numeric','min:0'],
            'compare_price' => ['nullable','numeric','min:0'],
            'cost_price' => ['nullable','numeric','min:0'],

            'stock_qty' => ['nullable','integer','min:0'],
            'track_stock' => ['nullable','boolean'],
            'allow_backorder' => ['nullable','boolean'],

            'short_description' => ['nullable','string','max:2000'],
            'description' => ['nullable','string'],

            'status' => ['required','in:draft,active,inactive'],

            // ✅ NEW: friendly input (optional)
            'attributes_text' => ['nullable','string','max:10000'],

            // existing
            'attributes_json' => ['nullable','string'],
            'variants_json' => ['nullable','string'],
            'shipping_json' => ['nullable','string'],

            'images' => ['nullable','array','max:10'],
            'images.*' => ['image','mimes:jpg,jpeg,png,webp','max:3072'],
        ]);

        // Normalize booleans
        $trackStock = (bool) ($request->input('track_stock', 1));
        $allowBackorder = (bool) ($request->input('allow_backorder', 0));

        $rawAttr = (string) $request->input('attributes_text', '');
        $rawAttr = trim($rawAttr);

        // Clean formatting
        $attributesText = null;
        if ($rawAttr !== '') {
            $lines = preg_split("/\r\n|\n|\r/", $rawAttr);
            $clean = [];

            foreach ($lines as $line) {
                $line = trim((string)$line);
                if ($line === '') continue;

                $line = preg_replace('/\s*:\s*/', ': ', $line);
                $line = preg_replace('/\s*,\s*/', ', ', $line);
                $line = preg_replace('/\s{2,}/', ' ', $line);

                $clean[] = $line;
            }

            $attributesText = !empty($clean) ? implode("\n", $clean) : null;
        }

        $baseSlug = Str::slug($request->input('slug') ?: $data['name']);
        if ($baseSlug === '') $baseSlug = 'product';

        // ✅ NEW: Decide final category id (prefer subcategory)
        $finalCategoryId = $this->resolveSellerCategoryId(
            $shop,
            $request->input('parent_category_id'),
            $request->input('seller_category_id')
        );

        return DB::transaction(function () use ($request, $data, $shop, $baseSlug, $trackStock, $allowBackorder, $attributesText, $finalCategoryId) {

            $slug = $this->uniqueSlug((int)$shop->id, $baseSlug);

            $product = Product::create([
                'shop_id' => (int) $shop->id,
                'seller_id' => (int) auth()->id(),

                // ✅ NEW: save category/subcategory
                'seller_category_id' => $finalCategoryId,

                'name' => $data['name'],
                'slug' => $slug,
                'sku' => $data['sku'] ?: null,

                'price' => $data['price'],
                'compare_price' => $data['compare_price'] ?? null,
                'cost_price' => $data['cost_price'] ?? null,
                'currency' => 'BDT',

                'stock_qty' => (int) ($data['stock_qty'] ?? 0),
                'track_stock' => $trackStock,
                'allow_backorder' => $allowBackorder,

                'short_description' => $data['short_description'] ?? null,
                'description' => $data['description'] ?? null,

                // ✅ FIX: store cleaned text (your old code used $data['attributes_text'] which isn't in $data)
                'attributes' => $attributesText,

                'variants' => $request->input('variants_json'),
                'shipping' => $request->input('shipping_json'),

                'status' => $data['status'],
                'seo_title' => $request->input('seo_title') ?: null,
                'seo_description' => $request->input('seo_description') ?: null,
            ]);

            // Images (first one becomes primary)
            $files = $request->file('images', []);
            $sort = 0;

            foreach ($files as $i => $file) {
                $path = $file->store("products/{$shop->id}/{$product->id}", 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $path,
                    'alt_text' => $product->name,
                    'sort_order' => $sort++,
                    'is_primary' => ($i === 0),
                ]);
            }

            $next = $request->input('save_next'); // "1" if Save & Add Another
            if ($next) {
                return redirect()
                    ->route('products.create')
                    ->with('success', 'Product saved ✅ Now add another one!');
            }

            return redirect()
                ->route('products.create')
                ->with('success', 'Product saved ✅');
        });
    }

    private function uniqueSlug(int $shopId, string $baseSlug): string
    {
        $slug = $baseSlug;
        $n = 2;

        while (Product::where('shop_id', $shopId)->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $n;
            $n++;
        }
        return $slug;
    }

    private function sellerShop()
    {
        return Shop::where('user_id', auth()->id())->firstOrFail();
    }

    /**
     * ✅ NEW: Validate + resolve category id.
     * Priority: seller_category_id (subcategory) -> parent_category_id -> null
     */
    private function resolveSellerCategoryId(Shop $shop, $parentId, $childId): ?int
    {
        $sellerId = (int) auth()->id();
        $shopId   = (int) $shop->id;

        $parentId = $parentId !== null && $parentId !== '' ? (int) $parentId : null;
        $childId  = $childId !== null && $childId !== '' ? (int) $childId : null;

        // Validate parent scope (must belong to same seller+shop)
        if ($parentId) {
            $okParent = SellerCategory::query()
                ->where('id', $parentId)
                ->where('shop_id', $shopId)
                ->where('seller_id', $sellerId)
                ->exists();

            if (!$okParent) {
                abort(422, 'Invalid parent category.');
            }
        }

        // Validate child scope + ensure it belongs to parent if parent given
        if ($childId) {
            $child = SellerCategory::query()
                ->where('id', $childId)
                ->where('shop_id', $shopId)
                ->where('seller_id', $sellerId)
                ->first();

            if (!$child) {
                abort(422, 'Invalid subcategory.');
            }

            if ($parentId && (int)($child->parent_id ?? 0) !== (int)$parentId) {
                abort(422, 'Subcategory does not belong to selected parent category.');
            }

            return (int) $childId;
        }

        return $parentId ? (int) $parentId : null;
    }

    public function show(string $slug)
    {
        // 1) Load product + images (and primaryImage) + category
        $ad = Product::query()
            ->where('slug', $slug)
            ->where('status', 'active')
            ->with(['images', 'primaryImage', 'category', 'category.parent'])
            ->firstOrFail();

        // 2) Build images array (primary first)
        $images = [];

        if ($ad->primaryImage && !empty($ad->primaryImage->path)) {
            $images[] = $ad->primaryImage->path;
        }

        foreach ($ad->images as $img) {
            if (empty($img->path)) continue;
            if (in_array($img->path, $images, true)) continue;
            $images[] = $img->path;
        }

        if (empty($images)) {
            $images = ['https://dummyimage.com/1200x800/f2f4f8/111&text=No+Image'];
        }

        // 3) Load shop info
        $shop = null;
        if (!empty($ad->shop_id) && class_exists(\App\Models\Shop::class)) {
            $shop = \App\Models\Shop::query()->where('id', $ad->shop_id)->first();
        }

        // 4) Optional specs (+ category)
        $specs = [
            'SKU' => $ad->sku ?: '—',
            'Stock' => (string)($ad->stock_qty ?? 0),
            'Currency' => $ad->currency ?: 'BDT',
            'Category' => $ad->category?->parent
                ? ($ad->category->parent->name . ' > ' . $ad->category->name)
                : ($ad->category->name ?? '—'),
        ];

        return view('seller.products.view', [
            'ad'     => $ad,
            'images' => $images,
            'shop'   => $shop,
            'specs'  => $specs,
        ]);
    }
}
