<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Classified Ads</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root { --card-border:#f0b37a; --soft-bg:#fff7ef; }
        .bg-page{ background:#f3f5f7; }
        .searchbar{ width:100%; max-width:560px; }
        .searchbar .form-control{ border-radius:999px 0 0 999px; }
        .searchbar .btn{ border-radius:0 999px 999px 0; }
        .chip-btn{ border-radius:999px; padding:.45rem .85rem; }
        .sidebar-links .list-group-item{ border:0; padding-left:0; padding-right:0; }
        .sidebar-links .list-group-item:hover{ text-decoration:underline; }
        .listing-card{ background:var(--soft-bg); border:2px solid var(--card-border); border-radius:8px; overflow:hidden; }
        .listing-img{ width:170px; height:120px; object-fit:cover; background:#e9ecef; }
        @media (max-width:575.98px){ .listing-img{ width:120px; height:95px; } }
        .listing-title{ font-weight:700; margin-bottom:.25rem; }
        .listing-meta{ font-size:.9rem; color:#6c757d; }
        .price{ color:#0c8f5a; font-weight:800; }
        .badge-pill{ border-radius:999px; font-weight:600; }
        .action-icons{ display:flex; gap:.5rem; align-items:center; }
        .action-icons .icon-btn{
            width:34px; height:34px; border-radius:10px; display:grid; place-items:center;
            background:white; border:1px solid rgba(0,0,0,.08);
        }
        .cat-active{ font-weight:700; }
        a{ text-decoration:none; }
    </style>
</head>

<body class="bg-page">
@php
    $qs = request()->query();

    $catNotFound = $catNotFound ?? false;
    $selectedCategory = $selectedCategory ?? null;

    $baseUrl = $selectedCategory
        ? route('sellercategoryproducts', $selectedCategory->slug)
        : url()->current();

    $buildUrl = function(array $merge) use ($baseUrl, $qs) {
        $new = array_merge($qs, $merge);
        foreach ($new as $k => $v) {
            if ($v === null || $v === '') unset($new[$k]);
        }
        $query = http_build_query($new);
        return $query ? ($baseUrl.'?'.$query) : $baseUrl;
    };

    $categoryLabel = $selectedCategory ? $selectedCategory->name : 'Category';
@endphp

@php
    $content = \App\Models\SiteContent::where('key', 'home')->first();
@endphp

<header class="bg-white border-bottom sticky-top">
    <div class="container py-3">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="h5 fw-bold mb-1">
                    <img src="{{ asset('storage').'/'.$content->logo_image }}" width="220" height="60" alt="">
                </h1>
                <div class="text-muted small">
                    Home <span class="mx-1">›</span> Ads
                    @if($selectedCategory)
                        <span class="mx-1">›</span> {{ $selectedCategory->name }}
                    @endif
                </div>
            </div>

            <form class="searchbar ms-lg-auto" method="GET" action="{{ $baseUrl }}">
                <div class="input-group">
                    <input name="q" value="{{ $filters['q'] ?? '' }}" type="search"
                           class="form-control form-control-lg" placeholder="Search by title, slug, description, location..." />
                    <input type="hidden" name="sort" value="{{ $filters['sort'] ?? 'newest' }}">
                    <input type="hidden" name="per_page" value="{{ $filters['per_page'] ?? 12 }}">
                    <button class="btn btn-warning btn-lg px-4" type="submit" aria-label="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
            <button class="btn btn-outline-success chip-btn" type="button" disabled>
                <i class="bi bi-sliders me-1"></i> Refine
            </button>

            <span class="btn btn-success chip-btn disabled">
                {{ $categoryLabel }}
            </span>

            <div class="dropdown ms-auto">
                <button class="btn btn-outline-secondary chip-btn dropdown-toggle" data-bs-toggle="dropdown">
                    Sort: {{ $filters['sort'] ?? 'newest' }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ $buildUrl(['sort'=>'newest','page'=>null]) }}">Newest</a></li>
                    <li><a class="dropdown-item" href="{{ $buildUrl(['sort'=>'price_low','page'=>null]) }}">Price: Low to High</a></li>
                    <li><a class="dropdown-item" href="{{ $buildUrl(['sort'=>'price_high','page'=>null]) }}">Price: High to Low</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<main class="container py-4">
    <div class="row g-4">
        <aside class="col-12 col-lg-3">
            <div class="bg-white border rounded-3 p-3">
                <div class="fw-semibold mb-2 text-muted small">Categories</div>

                <div class="list-group list-group-flush sidebar-links">
                    @foreach($categories->where('parent_id', null) as $cat)
                        @php
                            $catUrl = route('sellercategoryproducts', $cat->slug);
                            $catUrl = count($qs) ? ($catUrl . '?' . http_build_query($qs)) : $catUrl;

                            $isActive = $selectedCategory && ((string)$selectedCategory->id === (string)$cat->id);
                            $count = (int)($categoryCounts[$cat->id] ?? 0);
                        @endphp

                        <a class="list-group-item d-flex justify-content-between align-items-center {{ $isActive ? 'cat-active' : '' }}"
                           href="{{ $catUrl }}">
                            <span><i class="bi bi-tag me-2"></i>{{ $cat->name }}</span>
                            <span class="text-muted small">({{ number_format($count) }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        <section class="col-12 col-lg-9">
            @if($catNotFound)
                <div class="alert alert-warning d-flex align-items-start gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>
                        <div class="fw-bold">Category not found</div>
                        <div class="small text-muted">
                            The category you selected doesn’t exist anymore or the link is invalid.
                        </div>
                        @php $firstCat = $categories->where('parent_id', null)->first(); @endphp
                        @if($firstCat)
                            <div class="mt-2">
                                <a class="btn btn-sm btn-outline-secondary"
                                   href="{{ route('sellercategoryproducts', $firstCat->slug) }}">
                                    Browse categories
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div class="text-muted">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}
                    of {{ number_format($products->total()) }} ads
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        Per page: {{ $filters['per_page'] ?? 12 }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach([12, 24, 48] as $pp)
                            <li><a class="dropdown-item" href="{{ $buildUrl(['per_page'=>$pp,'page'=>null]) }}">{{ $pp }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="vstack gap-3">
                @forelse($products as $p)
                    @php
                        $img = null;

                        if (isset($p->primaryImage)) {
                            if ($p->primaryImage instanceof \Illuminate\Support\Collection) {
                                $img = optional($p->primaryImage->first())->image_path;
                            } else {
                                $img = optional($p->primaryImage)->image_path;
                            }
                        }

                        if (!$img && isset($p->images) && $p->images instanceof \Illuminate\Support\Collection && $p->images->count()) {
                            $img = optional($p->images->first())->image_path;
                        }

                        if ($img) {
                            $imgUrl = str_starts_with($img, 'http')
                                ? $img
                                : asset('storage/' . ltrim($img, '/'));
                        } else {
                            $imgUrl = 'https://via.placeholder.com/340x240?text=No+Image';
                        }

                        $statusLabel = is_string($p->status) ? strtoupper($p->status) : 'PUBLISHED';
                        $categoryName = optional($p->category)->name;
                    @endphp

                    <article class="listing-card">
                        <a href="{{ route('product.view', $p->slug) }}">
                            <div class="d-flex">
                                <img class="listing-img" src="{{ $imgUrl }}" alt="{{ $p->title }}">
                                <div class="p-3 flex-grow-1">
                                    <div class="d-flex justify-content-between gap-3">
                                        <div>
                                            <div class="listing-title">{{ $p->title }}</div>

                                            <div class="listing-meta">
                                                @if($categoryName)
                                                    {{ $categoryName }}
                                                @endif
                                                @if(!empty($p->location))
                                                    • {{ $p->location }}
                                                @endif
                                                @if(!empty($p->condition_type))
                                                    • {{ ucfirst($p->condition_type) }}
                                                @endif
                                            </div>

                                            <div class="price mt-2">
                                                @if($p->price_type === 'call')
                                                    Call for price
                                                @elseif(!is_null($p->price))
                                                    Tk {{ number_format((float) $p->price, 2) }}
                                                    @if($p->price_type === 'negotiable')
                                                        <span class="text-muted fw-normal small">(Negotiable)</span>
                                                    @endif
                                                @else
                                                    Price not set
                                                @endif
                                            </div>

                                            <div class="d-flex flex-wrap gap-2 mt-2">
                                                <span class="badge text-bg-light text-dark border badge-pill">
                                                    {{ $statusLabel }}
                                                </span>
                                                @if(!empty($p->price_type))
                                                    <span class="badge text-bg-light text-dark border badge-pill">
                                                        {{ strtoupper($p->price_type) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="action-icons">
                                        </div>
                                    </div>

                                    @if(!empty($p->description))
                                        <div class="text-muted small mt-2">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($p->description), 120) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="bg-white border rounded-3 p-4 text-center text-muted">
                        @if($selectedCategory)
                            No ads found in <span class="fw-semibold">{{ $selectedCategory->name }}</span>.
                        @else
                            No ads found.
                        @endif
                    </div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </section>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>