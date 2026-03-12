<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Classifieds\Models\ClassifiedAd as Product;
use App\Modules\Classifieds\Models\ClassifiedAdImage as ProductImage;
use App\Modules\Classifieds\Models\ClassifiedCategory as SellerCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductsController extends Controller
{
    public function create()
    {
        $parentCategories = SellerCategory::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('seller.products.create', compact('parentCategories'));
    }

    /**
     * AJAX endpoint to fetch subcategories by parent_id
     */
    public function categoryChildren(Request $request)
    {
        $parentId = (int) $request->get('parent_id', 0);

        $children = SellerCategory::query()
            ->where('parent_id', $parentId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'parent_id']);

        return response()->json(['data' => $children]);
    }

    public function store(Request $request)
    {
        $adUserId = auth('classified_ad')->id() ?? auth()->id();

        abort_if(!$adUserId, 401, 'Please login first.');

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],

            // category
            'parent_category_id' => ['nullable', 'integer', 'exists:classified_categories,id'],
            'category_id' => ['nullable', 'integer', 'exists:classified_categories,id'],
            'seller_category_id' => ['nullable', 'integer', 'exists:classified_categories,id'], // backward compatibility

            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_type' => ['nullable', 'in:fixed,negotiable,call'],
            'condition_type' => ['nullable', 'in:new,used'],
            'location' => ['nullable', 'string', 'max:255'],

            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:30'],

            'status' => ['nullable', 'in:pending,published,rejected,sold'],
            'published_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date'],

            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $baseSlug = Str::slug($request->input('slug') ?: $data['title']);
        if ($baseSlug === '') {
            $baseSlug = 'classified-ad';
        }

        $finalCategoryId = $this->resolveSellerCategoryId(
            $request->input('parent_category_id'),
            $request->input('category_id', $request->input('seller_category_id'))
        );

        return DB::transaction(function () use ($request, $data, $adUserId, $baseSlug, $finalCategoryId) {
            $slug = $this->uniqueSlug($baseSlug);

            $status = $data['status'] ?? 'pending';

            $ad = Product::create([
                'classified_ad_user_id' => (int) $adUserId,
                'category_id'           => $finalCategoryId,

                'title'                 => $data['title'],
                'slug'                  => $slug,
                'description'           => $data['description'] ?? null,

                'price'                 => $data['price'] ?? null,
                'price_type'            => $data['price_type'] ?? 'fixed',
                'condition_type'        => $data['condition_type'] ?? null,
                'location'              => $data['location'] ?? null,

                'contact_name'          => $data['contact_name'],
                'contact_email'         => $data['contact_email'] ?? null,
                'contact_phone'         => $data['contact_phone'],

                'status'                => $status,
                'published_at'          => $status === 'published'
                    ? ($data['published_at'] ?? now())
                    : null,
                'expires_at'            => $data['expires_at'] ?? null,
            ]);

            $files = $request->file('images', []);
            $sort = 0;

            foreach ($files as $i => $file) {
                $path = $file->store("classifieds/{$ad->id}", 'public');

                ProductImage::create([
                    'classified_ad_id' => $ad->id,
                    'image_path'       => $path,
                    'sort_order'       => $sort++,
                    'is_primary'       => ($i === 0),
                ]);
            }

            $next = $request->input('save_next');
            if ($next) {
                return redirect()
                    ->route('products.create')
                    ->with('success', 'Ad saved ✅ Now add another one!');
            }

            return redirect()
                ->route('products.create')
                ->with('success', 'Ad saved ✅');
        });
    }

    private function uniqueSlug(string $baseSlug): string
    {
        $slug = $baseSlug;
        $n = 2;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $n;
            $n++;
        }

        return $slug;
    }

    /**
     * Validate + resolve category id.
     * Priority: category_id / seller_category_id (child) -> parent_category_id -> null
     */
    private function resolveSellerCategoryId($parentId, $childId): ?int
    {
        $parentId = $parentId !== null && $parentId !== '' ? (int) $parentId : null;
        $childId  = $childId !== null && $childId !== '' ? (int) $childId : null;

        if ($parentId) {
            $parent = SellerCategory::query()
                ->where('id', $parentId)
                ->where('is_active', true)
                ->first();

            if (!$parent) {
                abort(422, 'Invalid parent category.');
            }
        }

        if ($childId) {
            $child = SellerCategory::query()
                ->where('id', $childId)
                ->where('is_active', true)
                ->first();

            if (!$child) {
                abort(422, 'Invalid subcategory.');
            }

            if ($parentId && (int) ($child->parent_id ?? 0) !== (int) $parentId) {
                abort(422, 'Subcategory does not belong to selected parent category.');
            }

            return (int) $childId;
        }

        return $parentId ? (int) $parentId : null;
    }

    public function show(string $slug)
    {
        $ad = Product::query()
            ->where('slug', $slug)
            ->whereIn('status', ['published', 'sold'])
            ->with([
                'images',
                'primaryImage',
                'category',
                'category.parent',
                'adUser',
            ])
            ->firstOrFail();

        $images = [];

        if ($ad->primaryImage && !empty($ad->primaryImage->image_path)) {
            $images[] = $ad->primaryImage->image_path;
        }

        foreach ($ad->images as $img) {
            if (empty($img->image_path)) {
                continue;
            }

            if (in_array($img->image_path, $images, true)) {
                continue;
            }

            $images[] = $img->image_path;
        }

        if (empty($images)) {
            $images = ['https://dummyimage.com/1200x800/f2f4f8/111&text=No+Image'];
        }

        $specs = [
            'Price Type' => $ad->price_type ?: '—',
            'Condition'  => $ad->condition_type ?: '—',
            'Location'   => $ad->location ?: '—',
            'Category'   => $ad->category?->parent
                ? ($ad->category->parent->name . ' > ' . $ad->category->name)
                : ($ad->category->name ?? '—'),
            'Views'      => (string) ($ad->views_count ?? 0),
            'Status'     => $ad->status ?: '—',
        ];

        return view('seller.products.view', [
            'ad'     => $ad,
            'images' => $images,
            'shop'   => null,
            'specs'  => $specs,
        ]);
    }

    public function seller_products(Request $request, $category)
    {
        $q       = trim((string) $request->get('q', ''));
        $sort    = (string) $request->get('sort', 'newest'); // newest|price_low|price_high
        $status  = $request->get('status');
        $perPage = (int) $request->get('per_page', 12);
        $perPage = $perPage > 0 ? min($perPage, 48) : 12;

        $selectedCategory = SellerCategory::query()
            ->select(['id', 'name', 'slug', 'parent_id'])
            ->where('id', $category)
            ->orWhere('slug', $category)
            ->first();

        $categories = SellerCategory::query()
            ->select(['id', 'name', 'slug', 'parent_id'])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $categoryCounts = Product::query()
            ->whereIn('status', ['published', 'sold'])
            ->selectRaw('category_id, COUNT(*) as total')
            ->groupBy('category_id')
            ->pluck('total', 'category_id');

        if (!$selectedCategory) {
            $products = Product::query()
                ->whereRaw('1=0')
                ->paginate($perPage)
                ->withQueryString();

            return view('seller.categoryproducts', [
                'products'         => $products,
                'categories'       => $categories,
                'categoryCounts'   => $categoryCounts,
                'selectedCategory' => null,
                'catNotFound'      => true,
                'filters'          => [
                    'q' => $q,
                    'sort' => $sort,
                    'per_page' => $perPage,
                ],
            ]);
        }

        $categoryIds = [$selectedCategory->id];

        $childIds = SellerCategory::query()
            ->where('parent_id', $selectedCategory->id)
            ->pluck('id')
            ->toArray();

        if (!empty($childIds)) {
            $categoryIds = array_merge($categoryIds, $childIds);
        }

        $query = Product::query()
            ->with([
                'primaryImage:id,classified_ad_id,image_path,is_primary',
                'images:id,classified_ad_id,image_path,is_primary',
                'category:id,name,slug,parent_id',
            ])
            ->whereIn('category_id', $categoryIds);

        if ($q !== '') {
            $query->where(function ($qq) use ($q) {
                $qq->where('title', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('location', 'like', "%{$q}%");
            });
        }

        if (!empty($status)) {
            $query->where('status', $status);
        } else {
            $query->whereIn('status', ['published', 'sold']);
        }

        if ($sort === 'price_low') {
            $query->orderBy('price', 'asc');
        } elseif ($sort === 'price_high') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest('id');
        }

        $products = $query->paginate($perPage)->withQueryString();

        return view('seller.categoryproducts', [
            'products'         => $products,
            'categories'       => $categories,
            'categoryCounts'   => $categoryCounts,
            'selectedCategory' => $selectedCategory,
            'catNotFound'      => false,
            'filters'          => [
                'q' => $q,
                'sort' => $sort,
                'per_page' => $perPage,
            ],
        ]);
    }

    public function destroyImage($id)
    {
        $image = ProductImage::query()->findOrFail($id);

        if (!empty($image->image_path) && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}