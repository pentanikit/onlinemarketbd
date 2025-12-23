<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
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



    public function destroy(Category $category)
    {
        $category->delete(); // children will cascade delete because of FK cascadeOnDelete()

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}

