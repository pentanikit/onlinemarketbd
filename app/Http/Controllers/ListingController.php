<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Category;
use App\Models\City;
use App\Models\ListingAddress;
use App\Models\ListingHour;
use App\Models\ListingPhotos;
use App\Models\ListingOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class ListingController extends Controller
{

    public function create()
    {
        $categories = Category::where('parent_id', null)->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('frontend.listing.onboarding', compact('categories'));
    }

    /**
     * Handle onboarding form submit
     */
    public function store(Request $request)
    {
        // ✅ 1) Validate input (including file-safe validation)
        $validated = $request->validate([
            // Step 1 – business info
            'name'         => ['required', 'string', 'max:255'],
            'type'         => ['required', 'string', 'max:50'],
            'category_id'  => ['nullable', 'exists:categories,id'],
            'tagline'      => ['nullable', 'string', 'max:255'],
            'description'  => ['required', 'string'],

            // Step 2 – contact & location
            'email'        => ['required', 'email:rfc,dns', 'max:255'],
            'phone'        => ['required', 'string', 'max:30'],
            'country'      => ['required', 'string', 'size:2'],
            'city'         => ['required', 'string', 'max:150'],
            'area'         => ['nullable', 'string', 'max:150'],
            'address_line1'=> ['required', 'string', 'max:255'],
            'address_line2'=> ['nullable', 'string', 'max:255'],
            'postal_code'  => ['nullable', 'string', 'max:20'],
            'website'      => ['nullable', 'max:255'],

            // Step 3 – details & hours & photos
            'price_level'  => ['nullable', 'string', 'max:50'],
            'highlights'   => ['nullable', 'string'],

            // Open/Close times (both optional, but format must match if present)
            'opens_at'     => ['nullable', 'date_format:H:i'],
            'closes_at'    => ['nullable', 'date_format:H:i'],

            // If you're storing open_days as string like "sat-sun" or "all", keep string rule.
            'open_days'    => ['nullable', 'string', 'max:50'],

            // Photos (array upload)
            'photos'       => ['nullable', 'array', 'max:10'],
            'photos.*'     => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:5072'], // ~5MB

            // Step 4 – documents
            'owner_name'      => ['required', 'string', 'max:255'],
            'nid_number'      => ['nullable', 'string', 'max:50'],

            // docs are optional, validate only if present
            'nid_front'       => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],
            'nid_back'        => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],
            'trade_license'   => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],
            'tax_document'    => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf', 'max:5120'],

            'agreed_terms'    => ['accepted'],
        ], [
            'agreed_terms.accepted' => 'You must accept the terms and conditions.',
        ]);

        // Small helper: store file safely
        $storeFile = function (Request $request, string $key, string $dir, string $disk = 'public'): ?string {
            if (!$request->hasFile($key)) return null;
            $file = $request->file($key);
            if (!$file || !$file->isValid()) return null;
            return $file->store($dir, $disk);
        };

        $listing = null;

        DB::transaction(function () use ($request, $validated, &$listing, $storeFile) {

            // ✅ 2) City: find or create
            $city = City::firstOrCreate(
                [
                    'country_code' => strtoupper($validated['country']),
                    'name'         => $validated['city'],
                ],
                [
                    'slug' => Str::slug($validated['city'] . '-' . strtoupper($validated['country'])),
                ]
            );

            // ✅ 3) Generate slug (unique)
            $baseSlug = Str::slug($validated['name'] . '-' . $validated['city']);
            $slug     = $baseSlug;
            $counter  = 1;

            while (Listing::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter++;
            }

            // ✅ 4) Create listing
            $listing = Listing::create([
                'user_id'      => Auth::id(),
                'tracking_id'  => 'TRK-' . strtoupper(substr(md5((string) now()), 0, 5)),
                'category_id'  => $validated['category_id'] ?? null,
                'city_id'      => $city->id,
                'name'         => $validated['name'],
                'slug'         => $slug,
                'type'         => $validated['type'],
                'tagline'      => $validated['tagline'] ?? null,
                'description'  => $validated['description'],
                'email'        => $validated['email'],
                'phone'        => $validated['phone'],
                'website'      => $validated['website'] ?? null,
                'price_level'  => $validated['price_level'] ?? null,
                'highlights'   => $validated['highlights'] ?? null,
                'status'       => 'pending',
                'is_claimed'   => Auth::check(),
            ]);

            // ✅ 5) Address
            ListingAddress::create([
                'listing_id'   => $listing->id,
                'country_code' => strtoupper($validated['country']),
                'city_id'      => $city->id,
                'city_name'    => $validated['city'],
                'area'         => $validated['area'] ?? null,
                'line1'        => $validated['address_line1'],
                'line2'        => $validated['address_line2'] ?? null,
                'postal_code'  => $validated['postal_code'] ?? null,
            ]);

            // ✅ 6) Opening hours
            $days = $this->mapOpenDaysToArray($validated['open_days'] ?? null);

            $opens  = $validated['opens_at'] ?? null;
            $closes = $validated['closes_at'] ?? null;

            // If days selected but both times empty => skip.
            // If one time given and other not given => still save as given (or you can enforce both needed).
            if (!empty($days) && ($opens || $closes)) {
                foreach ($days as $dayOfWeek) {
                    ListingHour::create([
                        'listing_id' => $listing->id,
                        'day_of_week'=> $dayOfWeek,
                        'opens_at'   => $opens,
                        'closes_at'  => $closes,
                        'is_closed'  => false,
                        'is_24_hours'=> false,
                    ]);
                }
            }

            // ✅ 7) Photos (multiple)
            if ($request->hasFile('photos')) {
                $files = $request->file('photos');

                // Ensure it's always an array
                if (!is_array($files)) {
                    $files = [$files];
                }

                $sort = 0;
                foreach ($files as $photo) {
                    if (!$photo || !$photo->isValid()) continue;

                    $path = $photo->store('listing_photos', 'public');

                    ListingPhotos::create([
                        'listing_id' => $listing->id,
                        'path'       => $path,
                        'alt_text'   => $listing->name . ' photo ' . ($sort + 1),
                        'is_primary' => $sort === 0, // first valid photo becomes primary
                        'sort_order' => $sort,
                    ]);

                    $sort++;
                }
            }

            // ✅ 8) Owner verification + documents (ONLY if files exist)
            $nidFrontPath     = $storeFile($request, 'nid_front', 'listing_docs');
            $nidBackPath      = $storeFile($request, 'nid_back', 'listing_docs');
            $tradeLicensePath = $storeFile($request, 'trade_license', 'listing_docs');
            $taxDocPath       = $storeFile($request, 'tax_document', 'listing_docs');

            // Create owner row (even if docs are missing, still save owner info)
            ListingOwner::create([
                'listing_id'          => $listing->id,
                'owner_name'          => $validated['owner_name'],
                'nid_number'          => $validated['nid_number'] ?? null,
                'nid_front_path'      => $nidFrontPath,
                'nid_back_path'       => $nidBackPath,
                'trade_license_path'  => $tradeLicensePath,
                'tax_document_path'   => $taxDocPath,
                'verification_status' => 'pending',
                'agreed_terms'        => true,
                'agreed_at'           => now(),
            ]);
        });

        return view('thank-you')
            ->with('listing', $listing)
            ->with('success', 'Your listing has been submitted for review. We will contact you after verification.');
    }



    public function children(Request $request)
    {
        $parentId = $request->query('parent_id');

        if (!$parentId) {
            return response()->json([]);
        }

        return Category::query()
            ->where('parent_id', $parentId)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
    }



    public function pending(Request $request)
    {
        $q          = trim((string) $request->get('q', ''));
        $categoryId = $request->get('category_id');
        $cityId     = $request->get('city_id');

        // Treat empty string as null so no filter applies
        $q = $q !== '' ? $q : null;

        $listings = \App\Models\Listing::query()
            ->where('status', 'pending')
            ->with([
                'category:id,name',
                'city:id,name',
                'owner:id,name,email', // add phone here if your users table has it
                'address',
                'primaryPhoto',
            ])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%")
                    ->orWhere('tracking_id', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhereHas('owner', function ($o) use ($q) {
                        $o->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");

                        // If your users table has a phone column, keep this:
                        if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'phone')) {
                            $o->orWhere('phone', 'like', "%{$q}%");
                        }
                    });
                });
            })
            ->when($categoryId, fn($query) => $query->where('category_id', $categoryId))
            ->when($cityId, fn($query) => $query->where('city_id', $cityId))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $categories = \App\Models\Category::query()
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name']);

        $cities = \App\Models\City::query()
            ->orderBy('name')
            ->get(['id','name']);

        return view('backend.listing.pending-approval', compact('listings', 'categories', 'cities'));
    }


    public function show(Listing $listing)
    {
        // Only pending review page
        // abort_unless($listing->status === 'pending', 404);

        $listing->load([
            'category',
            'city',
            'owner',
            'address',
            'hours',
            'photos',
            'primaryPhoto',
            'ownerVerification',
        ]);

        return view('backend.listing.listing-details', compact('listing'));
    }

    public function approve(Request $request, Listing $listing)
    {
        // You can add permission checks here (Gate/Policy)
        $listing->update(['status' => 'active']);

        return redirect()->route('listings.pending')->with('success', 'Listing approved and published.');
    }

    public function reject(Request $request, Listing $listing)
    {
        $data = $request->validate([
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        // Store rejection reason into meta (since you already have meta array)
        $meta = $listing->meta ?? [];
        $meta['rejection_reason'] = $data['reason'] ?? 'Rejected by admin.';
        $meta['rejected_at'] = now()->toDateTimeString();

        $listing->update([
            'status' => 'rejected',
            'meta'   => $meta,
        ]);

        return redirect()->route('listings.pending')->with('success', 'Listing rejected.');
    }



    public function search(Request $request)
    {
        // Inputs
        $q       = trim((string) $request->get('q', ''));         // "What?"
        $where   = trim((string) $request->get('where', ''));     // "Where?" (text)
        $cityId  = $request->get('city_id');                      // optional (if you use dropdown)

        // Resolve city by ID or by typed name/slug
        $city = null;

        if (!empty($cityId)) {
            $city = City::query()->select('id','name','slug')->find($cityId);
        } elseif ($where !== '') {
            $city = City::query()
                ->select('id','name','slug')
                ->where('name', 'like', "%{$where}%")
                ->orWhere('slug', 'like', "%{$where}%")
                ->first();
        }

        // Top nav categories (parent categories)
        $topCategories = Category::parents()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name','slug','image']);

        // Listings query
        $listingsQuery = Listing::query()
            ->active()
            ->with([
                'category:id,name,slug',
                'city:id,name,slug',
                'address', // adjust fields if needed
                'primaryPhoto', // we will read ->path in blade (change if your column name differs)
            ])
            ->when($city?->id, fn($qq) => $qq->where('city_id', $city->id))
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('tagline', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
                });
            });

        $listings = (clone $listingsQuery)
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        // Sidebar: Popular categories based on counts in current search
        // (Works great even if you later add many categories)
        $popularCategories = Category::query()
            ->select('id','name','slug')
            ->withCount(['listings as listings_count' => function ($qq) use ($city, $q) {
                $qq->where('status', 'active')
                   ->when($city?->id, fn($x) => $x->where('city_id', $city->id))
                   ->when($q !== '', function ($x) use ($q) {
                       $x->where(function ($w) use ($q) {
                           $w->where('name', 'like', "%{$q}%")
                             ->orWhere('tagline', 'like', "%{$q}%")
                             ->orWhere('description', 'like', "%{$q}%");
                       });
                   });
            }])
            ->orderByDesc('listings_count')
            ->limit(6)
            ->get();

        // Sidebar: Featured listings (best rating in current search)
        $featured = (clone $listingsQuery)
            ->orderByDesc('avg_rating')
            ->orderByDesc('review_count')
            ->limit(3)
            ->get(['id','name','phone','slug','category_id','avg_rating','review_count']);

        // Breadcrumb/title
        $titleParts = [];
        if ($q !== '') $titleParts[] = $q;
        if ($city?->name) $titleParts[] = $city->name;

        $pageTitle = count($titleParts)
            ? 'Search Results: ' . implode(' in ', $titleParts)
            : 'Search Results';

        return view('frontend.search.search', compact(
            'q', 'where', 'cityId', 'city',
            'topCategories',
            'listings',
            'popularCategories',
            'featured',
            'pageTitle'
        ));
    }



    public function single_listing(Request $request, Listing $listing)
    {
        // Only active listing for public (change if you want)
        if ($listing->status !== 'active') {
            abort(404);
        }

        // Load relationships
        $listing->load([
            'category.parent',
            'city',
            'address',
            'hours',
            'photos',
            'primaryPhoto',
        ]);

        // Top nav parent categories
        $topCategories = Category::parents()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id','name','slug','image']);

        // Breadcrumb pieces
        $breadcrumb = [
            ['label' => 'Home', 'url' => url('/')],
        ];

        if ($listing->city) {
            $breadcrumb[] = ['label' => $listing->city->name, 'url' => '#'];
        }

        if ($listing->category) {
            // If category has parent, show parent then child
            if ($listing->category->parent) {
                $breadcrumb[] = [
                    'label' => $listing->category->parent->name,
                    'url' => route('frontend.category.show', $listing->category->parent->slug),
                ];
            }

            $breadcrumb[] = [
                'label' => $listing->category->name,
                'url' => route('frontend.category.show', $listing->category->slug),
            ];
        }

        $breadcrumb[] = ['label' => $listing->name, 'url' => route('frontend.listing.show', $listing->slug)];

        // Hours: group by day (expects ListingHour has day/open/close OR similar)
        // If your columns differ, I’ll adjust once you paste ListingHour migration.
        $hoursByDay = $listing->hours->sortBy('day_of_week')
            ->groupBy(fn($h) => $h->day_name);

        // Nearby places: show nearby cities based on same category (simple, dynamic)
        $nearbyCities = collect();
        if ($listing->category_id) {
            $nearbyCities = Listing::query()
                ->active()
                ->where('category_id', $listing->category_id)
                ->whereNotNull('city_id')
                ->where('city_id', '!=', $listing->city_id)
                ->with('city:id,name,slug')
                ->select('id','city_id')
                ->distinct()
                ->limit(6)
                ->get()
                ->pluck('city')
                ->filter()
                ->unique('id')
                ->values();
        }

        return view('frontend.listing.single-listing', compact(
            'listing',
            'topCategories',
            'breadcrumb',
            'hoursByDay',
            'nearbyCities'
        ));
    }




    public function edit(Listing $listing)
    {
        $listing->load(['category', 'city', 'address', 'hours', 'photos' => function($q){
            $q->orderBy('sort_order');
        }]);

        $categories = Category::orderBy('name')->get(['id','name']);
        $cities     = City::orderBy('name')->get(['id','name']);

        // Build 7-day hours default structure (if missing)
        $days = [
            ['key'=>'sat', 'label'=>'Saturday'],
            ['key'=>'sun', 'label'=>'Sunday'],
            ['key'=>'mon', 'label'=>'Monday'],
            ['key'=>'tue', 'label'=>'Tuesday'],
            ['key'=>'wed', 'label'=>'Wednesday'],
            ['key'=>'thu', 'label'=>'Thursday'],
            ['key'=>'fri', 'label'=>'Friday'],
        ];

        // Map existing hours by day key (supports day or day_name)
        $hoursMap = [];
        foreach ($listing->hours as $h) {
            $k = $h->day ?? null;
            if ($k) $hoursMap[$k] = $h;
        }

        return view('backend.listing.edit', compact('listing','categories','cities','days','hoursMap'));
    }


    public function update(Request $request, Listing $listing)
    {
        // Only validate fields that exist in THIS blade form
        $validated = $request->validate([
            // MAIN INFO
            'category_id' => 'required|exists:categories,id',
            'city_id'     => 'required|exists:cities,id',
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255',
            'type'        => 'nullable|string|max:50',
            'price_level' => 'nullable|integer|min:0|max:5',
            'status'      => 'required|in:pending,active,inactive,rejected',
            'tagline'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'highlights'  => 'nullable|string',

            // CONTACT + MAP
            'email'   => 'nullable|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'website' => 'nullable|url|max:255',
            'lat'     => 'nullable|numeric',
            'lng'     => 'nullable|numeric',

            // OWNER / SWITCH
            'is_claimed' => 'nullable|boolean',

            // PHOTOS
            'primary_photo'    => 'nullable|integer',
            'delete_photos'    => 'nullable|array',
            'delete_photos.*'  => 'integer',
            'new_photos'       => 'nullable|array|max:6',          // upload at a time (optional)
            'new_photos.*'     => 'file|image|max:4096',           // 4MB each
        ]);

        DB::transaction(function () use ($request, $listing, $validated) {

            // -----------------------------
            // 1) SLUG handling (optional, unique auto-fix)
            // -----------------------------
            if ($request->filled('slug')) {
                $baseSlug = Str::slug($request->input('slug'));
            } else {
                // if slug input not provided, keep existing
                $baseSlug = $listing->slug;
            }

            // If baseSlug changed (or was provided), ensure uniqueness
            if ($request->filled('slug')) {
                $slug = $baseSlug ?: Str::slug($request->input('name'));
                $try  = $slug;
                $i    = 1;

                while (
                    Listing::where('slug', $try)
                        ->where('id', '!=', $listing->id)
                        ->exists()
                ) {
                    $try = $slug . '-' . $i++;
                }

                $listing->slug = $try;
            }

            // -----------------------------
            // 2) LISTING fields update
            // -----------------------------
            $fillable = [
                'category_id',
                'city_id',
                'name',
                'type',
                'tagline',
                'description',
                'email',
                'phone',
                'website',
                'lat',
                'lng',
                'price_level',
                'highlights',
                'status',
            ];

            $listing->fill(Arr::only($validated, $fillable));

            // checkbox: unchecked means not sent → treat as 0
            $listing->is_claimed = $request->has('is_claimed');

            $listing->save();

            // -----------------------------
            // 3) ADDRESS update (line/area/postcode)
            // -----------------------------
            $addressData = [
                'line1'       => $request->input('address_line'),
                'area'        => $request->input('area'),
                'postal_code' => $request->input('postcode'),
            ];

            // Only touch address if any of these inputs exist in request
            $addressTouched = $request->hasAny(['address_line', 'area', 'postcode']);

            if ($addressTouched) {
                // If your Listing has relation: $listing->address()
                $listing->address()->updateOrCreate(
                    ['listing_id' => $listing->id],
                    [
                        'line1'       => $addressData['line1'],
                        'area'        => $addressData['area'],
                        'postal_code' => $addressData['postal_code'],
                    ]
                );
            }

            // -----------------------------
            // 4) PHOTOS: delete selected
            // -----------------------------
            $deleteIds = collect($request->input('delete_photos', []))
                ->filter()
                ->map(fn ($v) => (int) $v)
                ->values();

            if ($deleteIds->isNotEmpty()) {
                $photosToDelete = $listing->photos()
                    ->whereIn('id', $deleteIds)
                    ->get();

                foreach ($photosToDelete as $p) {
                    if (!empty($p->path)) {
                        Storage::disk('public')->delete($p->path);
                    }
                    $p->delete();
                }
            }

            // -----------------------------
            // 5) PHOTOS: set primary
            // -----------------------------
            if ($request->filled('primary_photo')) {
                $primaryId = (int) $request->input('primary_photo');

                // ensure this photo belongs to listing and is not deleted
                $exists = $listing->photos()->where('id', $primaryId)->exists();

                if ($exists) {
                    $listing->photos()->update(['is_primary' => 0]);
                    $listing->photos()->where('id', $primaryId)->update(['is_primary' => 1]);
                }
            } else {
                // if no primary selected and none exists, keep first as primary
                $hasPrimary = $listing->photos()->where('is_primary', 1)->exists();
                if (!$hasPrimary) {
                    $first = $listing->photos()->orderBy('sort_order')->orderBy('id')->first();
                    if ($first) {
                        $listing->photos()->update(['is_primary' => 0]);
                        $first->update(['is_primary' => 1]);
                    }
                }
            }

            // -----------------------------
            // 6) PHOTOS: upload new
            // -----------------------------
            if ($request->hasFile('new_photos')) {
                $existingCount = $listing->photos()->count();
                $maxTotal = 12; // you can change this global cap
                $allowedToAdd = max(0, $maxTotal - $existingCount);

                $files = $request->file('new_photos');
                $files = array_slice($files, 0, $allowedToAdd);

                $nextSort = (int) ($listing->photos()->max('sort_order') ?? -1) + 1;

                foreach ($files as $idx => $photo) {
                    if (!$photo || !$photo->isValid()) continue;

                    $path = $photo->store('listing_photos', 'public');

                    ListingPhotos::create([
                        'listing_id' => $listing->id,
                        'path'       => $path,
                        'alt_text'   => $listing->name . ' photo',
                        'is_primary' => 0,
                        'sort_order' => $nextSort + $idx,
                    ]);
                }

                // After adding, ensure one primary exists
                $hasPrimary = $listing->photos()->where('is_primary', 1)->exists();
                if (!$hasPrimary) {
                    $first = $listing->photos()->orderBy('sort_order')->orderBy('id')->first();
                    if ($first) {
                        $listing->photos()->update(['is_primary' => 0]);
                        $first->update(['is_primary' => 1]);
                    }
                }
            }
        });

        return back()->with('success', 'Listing updated successfully.');
    }





    /**
     * Map "Everyday" / "Mon – Fri" / etc. into day_of_week integers
     */
    protected function mapOpenDaysToArray(?string $openDays): array
    {
        if (!$openDays) {
            return [];
        }

        $openDays = trim($openDays);

        return match ($openDays) {
            'Everyday'        => [0, 1, 2, 3, 4, 5, 6],
            'Mon – Fri'       => [1, 2, 3, 4, 5],
            'Fri – Sat'       => [5, 6],
            default           => [], // "Custom (we’ll contact you)" or unknown
        };
    }
}
