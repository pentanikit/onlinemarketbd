<?php

namespace App\Http\Controllers;

use App\Modules\Classifieds\Models\ClassifiedAd;
use App\Modules\Classifieds\Models\ClassifiedAdImage;
use App\Modules\Classifieds\Models\ClassifiedAdUser;
use App\Modules\Classifieds\ClassifiedCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ClassifiedAdController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassifiedAd::with([
            'user',
            'category',
            'images',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('classified_ad_user_id')) {
            $query->where('classified_ad_user_id', $request->classified_ad_user_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('contact_name', 'like', "%{$search}%")
                  ->orWhere('contact_phone', 'like', "%{$search}%");
            });
        }

        $ads = $query->latest()->paginate($request->get('per_page', 20));

        return response()->json($ads);
    }

    public function publishedAds(Request $request)
    {
        $query = ClassifiedAd::with(['user', 'category', 'images'])
            ->where('status', 'published');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('slug')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->slug);
            });
        }

        $ads = $query->orderByDesc('published_at')->paginate($request->get('per_page', 20));

        return response()->json($ads);
    }

    public function show($id)
    {
        $ad = ClassifiedAd::with([
            'user',
            'category',
            'images',
        ])->findOrFail($id);

        $ad->increment('views_count');

        return response()->json($ad->fresh(['user', 'category', 'images']));
    }

    public function showBySlug($slug)
    {
        $ad = ClassifiedAd::with([
            'user',
            'category',
            'images',
        ])->where('slug', $slug)->firstOrFail();

        $ad->increment('views_count');

        return response()->json($ad->fresh(['user', 'category', 'images']));
    }

    public function store(Request $request)
    {
        $request->validate([
            'classified_ad_user_id' => 'required|exists:classified_ad_users,id',
            'category_id' => 'required|exists:classified_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'price_type' => 'nullable|string|in:fixed,negotiable,call',
            'condition_type' => 'nullable|string|in:new,used',
            'location' => 'nullable|string|max:255',
            'contact_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'required|string|max:30',
            'status' => 'nullable|string|in:pending,published,rejected,sold',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'primary_image' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;

            while (ClassifiedAd::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $ad = ClassifiedAd::create([
                'classified_ad_user_id' => $request->classified_ad_user_id,
                'category_id' => $request->category_id,
                'title' => $request->title,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'price_type' => $request->price_type ?? 'fixed',
                'condition_type' => $request->condition_type,
                'location' => $request->location,
                'contact_name' => $request->contact_name,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                'status' => $request->status ?? 'pending',
                'published_at' => $request->published_at,
                'expires_at' => $request->expires_at,
            ]);

            if ($request->filled('images')) {
                foreach ($request->images as $index => $imagePath) {
                    ClassifiedAdImage::create([
                        'classified_ad_id' => $ad->id,
                        'image_path' => $imagePath,
                        'is_primary' => $request->primary_image === $imagePath || ($index === 0 && !$request->filled('primary_image')),
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Classified ad created successfully.',
                'data' => $ad->load(['user', 'category', 'images']),
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to create classified ad.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $ad = ClassifiedAd::with('images')->findOrFail($id);

        $request->validate([
            'classified_ad_user_id' => 'nullable|exists:classified_ad_users,id',
            'category_id' => 'nullable|exists:classified_categories,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'price_type' => 'nullable|string|in:fixed,negotiable,call',
            'condition_type' => 'nullable|string|in:new,used',
            'location' => 'nullable|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:30',
            'status' => 'nullable|string|in:pending,published,rejected,sold',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'primary_image' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $data = [];

            if ($request->filled('classified_ad_user_id')) {
                $data['classified_ad_user_id'] = $request->classified_ad_user_id;
            }

            if ($request->filled('category_id')) {
                $data['category_id'] = $request->category_id;
            }

            if ($request->filled('title')) {
                $slug = Str::slug($request->title);
                $originalSlug = $slug;
                $count = 1;

                while (
                    ClassifiedAd::where('slug', $slug)
                        ->where('id', '!=', $ad->id)
                        ->exists()
                ) {
                    $slug = $originalSlug . '-' . $count++;
                }

                $data['title'] = $request->title;
                $data['slug'] = $slug;
            }

            if ($request->has('description')) {
                $data['description'] = $request->description;
            }

            if ($request->has('price')) {
                $data['price'] = $request->price;
            }

            if ($request->filled('price_type')) {
                $data['price_type'] = $request->price_type;
            }

            if ($request->has('condition_type')) {
                $data['condition_type'] = $request->condition_type;
            }

            if ($request->has('location')) {
                $data['location'] = $request->location;
            }

            if ($request->filled('contact_name')) {
                $data['contact_name'] = $request->contact_name;
            }

            if ($request->has('contact_email')) {
                $data['contact_email'] = $request->contact_email;
            }

            if ($request->filled('contact_phone')) {
                $data['contact_phone'] = $request->contact_phone;
            }

            if ($request->filled('status')) {
                $data['status'] = $request->status;
            }

            if ($request->has('published_at')) {
                $data['published_at'] = $request->published_at;
            }

            if ($request->has('expires_at')) {
                $data['expires_at'] = $request->expires_at;
            }

            $ad->update($data);

            if ($request->has('images')) {
                $ad->images()->delete();

                foreach ($request->images as $index => $imagePath) {
                    ClassifiedAdImage::create([
                        'classified_ad_id' => $ad->id,
                        'image_path' => $imagePath,
                        'is_primary' => $request->primary_image === $imagePath || ($index === 0 && !$request->filled('primary_image')),
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Classified ad updated successfully.',
                'data' => $ad->fresh(['user', 'category', 'images']),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to update classified ad.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $ad = ClassifiedAd::findOrFail($id);
        $ad->delete();

        return response()->json([
            'message' => 'Classified ad deleted successfully.',
        ]);
    }

    public function categories()
    {
        $categories = ClassifiedCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json($categories);
    }

    public function categoryAds($categoryId, Request $request)
    {
        $ads = ClassifiedAd::with(['user', 'category', 'images'])
            ->where('category_id', $categoryId)
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            }, function ($q) {
                $q->where('status', 'published');
            })
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json($ads);
    }

    public function userAds($userId, Request $request)
    {
        $ads = ClassifiedAd::with(['user', 'category', 'images'])
            ->where('classified_ad_user_id', $userId)
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json($ads);
    }

    public function markAsSold($id)
    {
        $ad = ClassifiedAd::findOrFail($id);
        $ad->update([
            'status' => 'sold',
        ]);

        return response()->json([
            'message' => 'Classified ad marked as sold.',
            'data' => $ad,
        ]);
    }

    public function publish($id)
    {
        $ad = ClassifiedAd::findOrFail($id);
        $ad->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        return response()->json([
            'message' => 'Classified ad published successfully.',
            'data' => $ad,
        ]);
    }

    public function pendingAds(Request $request)
    {
        $ads = ClassifiedAd::with(['user', 'category', 'images'])
            ->where('status', 'pending')
            ->latest()
            ->paginate($request->get('per_page', 20));

        return response()->json($ads);
    }
}