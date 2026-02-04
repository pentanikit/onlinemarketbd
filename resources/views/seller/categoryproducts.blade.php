{{-- resources/views/frontend/marketplace/mobiles.blade.php --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mobiles and Accessories for Sale in Bangladesh</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
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

<header class="bg-white border-bottom sticky-top">
    <div class="container py-3">
        <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3">
            <div>
                <h1 class="h5 fw-bold mb-1">Mobiles and Accessories for Sale in Bangladesh</h1>
                <div class="text-muted small">
                    Home <span class="mx-1">›</span> All ads <span class="mx-1">›</span> Mobiles
                </div>
            </div>

            <form class="searchbar ms-lg-auto" method="GET" action="#">
                <div class="input-group">
                    <input name="q" value="{{ $filters['q'] ?? '' }}" type="search"
                           class="form-control form-control-lg" placeholder="What are you looking for?" />
                    <input type="hidden" name="sort" value="{{ $filters['sort'] ?? 'newest' }}">
                    <input type="hidden" name="cat" value="{{ $filters['cat'] ?? '' }}">
                    <button class="btn btn-warning btn-lg px-4" type="submit" aria-label="Search">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Filter Chips --}}
        <div class="d-flex flex-wrap gap-2 mt-3 align-items-center">
            <button class="btn btn-outline-success chip-btn" type="button" disabled>
                <i class="bi bi-sliders me-1"></i> Refine
            </button>

            {{-- Category Dropdown (from DB) --}}
            <div class="dropdown">
                <button class="btn btn-success chip-btn dropdown-toggle" data-bs-toggle="dropdown">
                    {{ $filters['cat'] ? 'Category Selected' : 'Mobiles' }}
                    <span class="ms-1 badge text-bg-light text-success">×</span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="#">
                            All Mobiles
                        </a>
                    </li>
                    @foreach($categories->where('parent_id', null) as $cat)
                        <li>
                            <a class="dropdown-item"
                               href="#">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Sort --}}
            <div class="dropdown ms-auto">
                <button class="btn btn-outline-secondary chip-btn dropdown-toggle" data-bs-toggle="dropdown">
                    Sort by
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            Newest
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            Price: Low to High
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#">
                            Price: High to Low
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<main class="container py-4">
    <div class="row g-4">
        {{-- Sidebar --}}
        <aside class="col-12 col-lg-3">
            <div class="bg-white border rounded-3 p-3">
                <div class="fw-semibold mb-2 text-muted small">All Categories</div>

                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-phone text-secondary"></i>
                    <div class="fw-bold">Mobiles</div>
                </div>

                <div class="list-group list-group-flush sidebar-links">
                    @foreach($categories->where('parent_id', null) as $cat)
                        @php
                            $isActive = (string)($filters['cat'] ?? '') === (string)$cat->id;
                            $count = (int)($categoryCounts[$cat->id] ?? 0);
                        @endphp
                        <a class="list-group-item d-flex justify-content-between align-items-center {{ $isActive ? 'cat-active' : '' }}"
                           href="#">
                            <span><i class="bi bi-tag me-2"></i>{{ $cat->name }}</span>
                            <span class="text-muted small">({{ number_format($count) }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </aside>

        {{-- Content --}}
        <section class="col-12 col-lg-9">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
                <div class="text-muted">
                    Showing
                    {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}
                    of {{ number_format($products->total()) }} ads
                </div>

                <button class="btn btn-link text-decoration-none d-flex align-items-center gap-2" disabled>
                    <i class="bi bi-bookmark"></i> Save search
                </button>
            </div>

            <div class="vstack gap-3">
                @forelse($products as $p)
                    @php
                        $img = optional($p->primaryImage)->image_path;
                        if (!$img && $p->images && $p->images->count()) {
                            $img = $p->images->first()->image_path;
                        }
                        $imgUrl = $img
                            ? (str_starts_with($img, 'http') ? $img : asset($img))
                            : 'https://via.placeholder.com/340x240?text=No+Image';

                        $loc = 'Bangladesh'; // you can replace with shop location later
                        $statusLabel = is_string($p->status) ? strtoupper($p->status) : 'ACTIVE';
                    @endphp

                    <article class="listing-card">
                        <div class="d-flex">
                            <img class="listing-img" src="{{ $imgUrl }}" alt="{{ $p->name }}">
                            <div class="p-3 flex-grow-1">
                                <div class="d-flex justify-content-between gap-3">
                                    <div>
                                        <div class="listing-title">{{ $p->name }}</div>
                                        <div class="listing-meta">{{ $loc }}{{ $p->category ? ', '.$p->category->name : '' }}</div>
                                        <div class="price mt-2">
                                            Tk {{ number_format((float)$p->price) }}
                                        </div>

                                        <div class="d-flex flex-wrap gap-2 mt-2">
                                            @if($p->compare_price && (float)$p->compare_price > (float)$p->price)
                                                <span class="badge text-bg-warning badge-pill">FEATURED</span>
                                            @endif

                                            @if($p->stock_qty !== null)
                                                <span class="badge text-bg-secondary badge-pill">
                                                    STOCK: {{ (int)$p->stock_qty }}
                                                </span>
                                            @endif

                                            <span class="badge text-bg-light text-dark border badge-pill">
                                                {{ $statusLabel }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="action-icons">
                                        <button class="icon-btn" type="button" title="Promote">
                                            <i class="bi bi-arrow-up text-warning"></i>
                                        </button>
                                        <button class="icon-btn" type="button" title="Save">
                                            <i class="bi bi-bookmark text-danger"></i>
                                        </button>
                                    </div>
                                </div>

                                @if(!empty($p->short_description))
                                    <div class="text-muted small mt-2">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($p->short_description), 120) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="bg-white border rounded-3 p-4 text-center text-muted">
                        No products found.
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
