<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerProducts as Product;
use App\Models\ProductImages as ProductImage;
use App\Models\Shop; 

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductsController extends Controller
{
    public function create()
    {
        $shop = $this->sellerShop();

        return view('seller.products.create', compact('shop'));
    }

    public function store(Request $request)
    {
        $shop = $this->sellerShop();

        $data = $request->validate([
            'name' => ['required','string','max:180'],
            'sku' => ['nullable','string','max:80'],
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

        // Clean formatting (optional but nice):
        // - trims each line
        // - removes extra spaces
        // - normalizes commas: "a,  b" -> "a, b"
        $attributesText = null;

        if ($rawAttr !== '') {
            $lines = preg_split("/\r\n|\n|\r/", $rawAttr);
            $clean = [];

            foreach ($lines as $line) {
                $line = trim((string)$line);
                if ($line === '') continue;

                // normalize spaces around colon + commas
                $line = preg_replace('/\s*:\s*/', ': ', $line);
                $line = preg_replace('/\s*,\s*/', ', ', $line);
                $line = preg_replace('/\s{2,}/', ' ', $line);

                $clean[] = $line;
            }

            $attributesText = !empty($clean) ? implode("\n", $clean) : null;
        }


        $baseSlug = Str::slug($request->input('slug') ?: $data['name']);
        if ($baseSlug === '') $baseSlug = 'product';

        return DB::transaction(function () use ($request, $data, $shop, $baseSlug, $trackStock, $allowBackorder,) {

            $slug = $this->uniqueSlug((int)$shop->id, $baseSlug);

            $product = Product::create([
                'shop_id' => (int) $shop->id,
                'seller_id' => (int) auth()->id(),
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

                'attributes' => $data['attributes_text'],
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
        // ✅ Adjust this to your real shop relation if needed
        // Common patterns:
        // $shop = auth()->user()->shop;
        // or Shop::where('user_id', auth()->id())->firstOrFail();

        return Shop::where('user_id', auth()->id())->firstOrFail();
    }

    public function show(string $slug)
    {
        // 1) Load product + images (and primaryImage)
        $ad = Product::query()
            ->where('slug', $slug)
            ->where('status', 'active') // only show active products publicly
            ->with(['images', 'primaryImage'])
            ->firstOrFail();

        // 2) Build images array (primary first)
        $images = [];

        // prefer primary image first
        if ($ad->primaryImage && !empty($ad->primaryImage->path)) {
            $images[] = $ad->primaryImage->path;
        }

        foreach ($ad->images as $img) {
            if (empty($img->path)) continue;
            // avoid duplicate if primary already included
            if (in_array($img->path, $images, true)) continue;
            $images[] = $img->path;
        }

        // fallback if no images
        if (empty($images)) {
            $images = ['https://dummyimage.com/1200x800/f2f4f8/111&text=No+Image'];
        }

        // 3) Load shop info (if you have Shop model + table)
        // If your shop model name is different, rename this line.
        $shop = null;
        if (!empty($ad->shop_id) && class_exists(\App\Models\Shop::class)) {
            $shop = \App\Models\Shop::query()->where('id', $ad->shop_id)->first();
        }

        // 4) Optional specs (keep simple)
        $specs = [
            'SKU' => $ad->sku ?: '—',
            'Stock' => (string)($ad->stock_qty ?? 0),
            'Currency' => $ad->currency ?: 'BDT',
        ];

        // 5) Return your single listing view
        // If your blade file is different, update the view name below.
        return view('seller.products.view', [
            'ad'     => $ad,
            'images' => $images,
            'shop'   => $shop,
            'specs'  => $specs,
        ]);
    }
}
