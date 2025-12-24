<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $q    = $request->get('q');
        $type = $request->get('type'); // all|primary|sub

        $categoriesQuery = Category::query()
            ->with('parent')
            ->search($q)
            ->when($type === 'primary', fn($qq) => $qq->parents())
            ->when($type === 'sub', fn($qq) => $qq->subs())
            ->ordered();

        // If Listing model exists, this will show counts. If not, remove withCount('listings') from here + blade.
        $categories = $categoriesQuery->withCount('listings')->paginate(15)->withQueryString();

        $parents = Category::parents()->ordered()->get();

        return view('backend.categories.admin-categories', compact('categories', 'parents', 'q', 'type'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:150'],
            'slug'       => ['nullable', 'string', 'max:180'],
            'parent_id'  => ['nullable', 'integer', 'exists:categories,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],

            // NEW: category image upload
            'image'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'], // 2MB
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Handle image upload (storage/app/public/categories)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
            // Example saved path: categories/abc123.png
        }

        Category::create($data);

        return redirect()->back()->with('success', 'Category created successfully.');
    }


    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:150'],
            'slug'       => ['nullable', 'string', 'max:180'],
            'parent_id'  => ['nullable', 'integer', 'exists:categories,id', 'not_in:' . $category->id],
            'sort_order' => ['nullable', 'integer', 'min:0'],

            // NEW: category image upload (optional)
            'image'      => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'], // 2MB
        ]);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Handle image replacement
        if ($request->hasFile('image')) {

            // delete old image if exists
            if (!empty($category->image) && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            // store new
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->back()->with('success', 'Category updated successfully.');
    }



    public function show(Request $request, Category $category)
    {
        // Top nav (parent categories)
        $topCategories = Category::parents()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name','slug','image']);

        // Sidebar "Popular Cuisines" → sub categories of current parent (if any)
        $currentParent = $category->parent_id ? $category->parent : $category;
        $subCategories = Category::query()
            ->where('parent_id', $currentParent->id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name','slug','image']);

        // Filters
        $q      = trim((string) $request->get('q', ''));
        $cityId = $request->get('city_id'); // optional if you use city filter

        // Main listings query (active only)
        $listings = Listing::query()
            ->active()
            ->where('category_id', $category->id)
            ->with([
                'category:id,name,slug',
                'city:id,name,slug',
                'address', // adjust select if needed
                'primaryPhoto:id,listing_id,path,is_primary', // adjust column names
            ])
            ->when($cityId, fn($qq) => $qq->where('city_id', $cityId))
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('tagline', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        // Featured listings (example: highest rating within same category)
        $featured = Listing::query()
            ->active()
            ->where('category_id', $category->id)
            ->orderByDesc('avg_rating')
            ->orderByDesc('review_count')
            ->limit(3)
            ->get(['id','name','phone','slug','category_id']);

        // Breadcrumb pieces (simple)
        $breadcrumb = [
            ['label' => 'Home', 'url' => url('/')],
            ['label' => $currentParent->name, 'url' => route('frontend.category.show', $currentParent->slug)],
        ];
        if ($category->parent_id) {
            $breadcrumb[] = ['label' => $category->name, 'url' => route('frontend.category.show', $category->slug)];
        }

        return view('frontend.categories.categories', compact(
            'category',
            'currentParent',
            'topCategories',
            'subCategories',
            'listings',
            'featured',
            'breadcrumb',
            'q',
            'cityId'
        ));
    }


    public function destroy(Category $category)
    {
        // Delete stored image file first (if exists)
        if (!empty($category->image)) {
            $path = ltrim($category->image, '/');

            // If saved like "storage/categories/a.jpg", convert to "public/categories/a.jpg"
            if (str_starts_with($path, 'storage/')) {
                $path = 'public/' . substr($path, strlen('storage/'));
            }
            // If saved like "categories/a.jpg", treat it as public disk path
            elseif (!str_starts_with($path, 'public/')) {
                $path = 'public/' . $path;
            }

            if (Storage::exists($path)) {
                Storage::delete($path);
            }
        }

        // Then delete DB row (children cascade via FK)
        $category->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}

