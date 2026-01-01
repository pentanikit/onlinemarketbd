@extends('frontend.layout')

@push('styles')
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #ffffff;
        }

        .top-border-line {
            border-top: 1px solid #f0f0f0;
        }

        /* Header (same consistency as other pages) */
        .site-header {
            padding: 12px 0 8px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 24px;
            color: #00306b;
        }

        .logo-text span {
            color: #ff7a1a;
            font-weight: 600;
        }

        .logo-icon {
            width: 30px;
            height: 36px;
            border: 3px solid #00306b;
            border-radius: 6px;
            border-top-width: 6px;
            margin-right: 6px;
            position: relative;
        }

        .logo-icon::before {
            content: "";
            position: absolute;
            width: 60%;
            height: 10px;
            border: 3px solid #00306b;
            border-radius: 10px;
            border-bottom: none;
            top: -11px;
            left: 50%;
            transform: translateX(-50%);
        }

        .top-links a {
            font-size: 13px;
            margin-left: 14px;
            color: #333;
            text-decoration: none;
        }

        .top-links a i {
            margin-right: 5px;
        }

        .top-links a:hover {
            text-decoration: underline;
        }

        /* Yellow search bar */
        .header-search-bar {
            background-color: #f5f5f4;
            padding: 10px 0;
        }

        .header-search-bar .form-control,
        .header-search-bar .form-select {
            font-size: 14px;
        }

        .header-search-bar .search-label {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            color: #555;
            margin-bottom: 2px;
        }

        .header-search-bar .btn-find {
            background-color: #222;
            border-color: #222;
            color: #fff;
            font-weight: 600;
            padding-inline: 30px;
            margin-top: 23px;
        }

        /* Category nav strip */
        .category-top-nav {
            border-bottom: 1px solid #e5e5e5;
            padding: 10px 0;
            font-size: 13px;
        }

        .category-top-nav a {
            color: #444;
            text-decoration: none;
            margin-right: 22px;
            display: inline-flex;
            align-items: center;
        }

        .category-top-nav i {
            margin-right: 4px;
            font-size: 14px;
        }

        .category-top-nav a:hover {
            text-decoration: underline;
        }

        /* Breadcrumb */
        .breadcrumb-custom {
            font-size: 12px;
            color: #777;
            margin-top: 16px;
            margin-bottom: 6px;
        }

        .breadcrumb-custom a {
            color: #0073bb;
            text-decoration: none;
        }

        .breadcrumb-custom a:hover {
            text-decoration: underline;
        }

        /* Left sidebar cards */
        .side-card {
            border: 1px solid #e1e4ea;
            border-radius: 4px;
            padding: 14px 16px;
            margin-bottom: 12px;
            background-color: #fff;
            font-size: 13px;
        }

        .side-card h5 {
            font-size: 15px;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .side-main-phone {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .side-link-btn {
            display: flex;
            align-items: center;
            padding: 8px 0;
            border-top: 1px solid #eceff4;
            font-size: 13px;
        }

        .side-link-btn:first-of-type {
            border-top: none;
        }

        .side-link-btn i {
            width: 22px;
            text-align: center;
            margin-right: 6px;
            color: #0073bb;
        }

        .side-link-btn span {
            color: #0073bb;
            cursor: pointer;
        }

        .claim-box-title {
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .btn-claim {
            background-color: #0073bb;
            border-color: #0073bb;
            font-size: 13px;
            padding: 7px 12px;
            font-weight: 600;
        }

        .hours-label {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .hours-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .places-link {
            display: block;
            font-size: 13px;
            color: #0073bb;
            text-decoration: none;
            margin-bottom: 3px;
        }

        .places-link:hover {
            text-decoration: underline;
        }

        /* Main listing header */
        .listing-header {
            border-bottom: 1px solid #e1e4ea;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }

        .listing-main-title {
            font-size: 26px;
            font-weight: 700;
        }

        .listing-cats {
            font-size: 13px;
            color: #555;
        }

        .rating-stars {
            color: #ccc;
            font-size: 14px;
        }

        .review-link {
            font-size: 12px;
            margin-left: 8px;
            color: #0073bb;
            text-decoration: none;
        }

        .review-link:hover {
            text-decoration: underline;
        }

        .status-open {
            font-size: 13px;
            color: #22a05d;
            font-weight: 700;
        }

        .status-open i {
            margin-right: 4px;
        }

        .hours-today {
            font-size: 13px;
            color: #555;
        }

        .listing-meta-small {
            font-size: 12px;
            color: #777;
            margin-top: 6px;
        }

        .listing-meta-small i {
            margin-right: 4px;
        }

        .listing-thumb-main {
            width: 140px;
            height: 140px;
            border-radius: 3px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .listing-thumb-main img {
            max-width: 100%;
            max-height: 100%;
        }

        /* Menu cards */
        .menu-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .menu-card {
            border: 1px solid #e1e4ea;
            border-radius: 4px;
            padding: 12px 14px;
            font-size: 13px;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .menu-card h6 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .menu-card ul {
            padding-left: 18px;
            margin-bottom: 0;
        }

        .menu-card ul li {
            margin-bottom: 3px;
        }

        .btn-view-menu {
            font-size: 13px;
            border-color: #d0d4db;
            color: #333;
            margin-top: 4px;
        }

        /* Gallery */
        .gallery-title {
            font-size: 18px;
            font-weight: 700;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .gallery-title small {
            font-size: 12px;
            font-weight: 400;
        }

        .gallery-thumb {
            width: 100%;
            height: 120px;
            border-radius: 3px;
            overflow: hidden;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .gallery-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn-add-photo {
            font-size: 13px;
        }

        /* Footer */
        .site-footer {
            border-top: 1px solid #e5e5e5;
            padding: 16px 0;
            margin-top: 24px;
            font-size: 12px;
            color: #777;
        }

        @media (max-width: 767.98px) {
            .header-search-bar .btn-find {
                width: 100%;
                margin-top: 8px;
            }

            .listing-header {
                text-align: center;
            }

            .listing-header .text-md-start {
                text-align: center !important;
            }

            .listing-thumb-main {
                margin: 0 auto 10px;
            }
        }

        .yp-page-title {
            font-weight: 800;
        }

        .yp-info-wrap {
            border-top: 1px solid #f0f0f0;
            padding-top: 10px;
        }

        /* Each row block */
        .yp-info-block {
            display: grid;
            grid-template-columns: 220px 1fr;
            gap: 24px;
            padding: 14px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .yp-info-label {
            font-weight: 800;
            font-size: 13px;
            color: #111;
        }

        .yp-info-value {
            font-size: 14px;
            color: #222;
        }

        .yp-paragraph {
            line-height: 1.7;
            color: #333;
        }

        /* Links */
        .yp-link {
            color: #1a73e8;
            text-decoration: none;
        }

        .yp-link:hover {
            text-decoration: underline;
        }

        /* Small badge */
        .yp-badge {
            background: #1a73e8;
            color: #fff;
            border-radius: 2px;
            padding: 4px 7px;
            font-size: 12px;
        }

        /* Social */
        .yp-social {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 2px;
            background: #2d5bd1;
            color: #fff;
            text-decoration: none;
        }

        .yp-social:hover {
            filter: brightness(1.05);
            color: #fff;
        }

        /* =========================
                        Responsive
                    ========================= */
        @media (max-width: 992px) {
            .yp-info-block {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .yp-loc-group {
                max-width: none;
            }

            .yp-search-group {
                min-width: 180px;
            }
        }



        /* Reviews card (match your existing cards) */
        .yp-reviews-card {
            border: 1px solid #e1e4ea;
            border-radius: 4px;
            background: #fff;
            padding: 14px 16px;
        }

        .yp-reviews-title {
            font-weight: 800;
            font-size: 15px;
            color: #111;
        }

        .yp-review-action {
            font-size: 13px;
        }

        .yp-review-score {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
            color: #111;
        }

        .yp-review-stars {
            color: #ccc;
            font-size: 14px;
        }

        .yp-review-meta {
            font-size: 12px;
            color: #777;
            margin-top: 2px;
        }

        .yp-review-empty {
            font-size: 13px;
            color: #555;
            background: #f7f7f7;
            border: 1px dashed #dcdcdc;
            border-radius: 4px;
            padding: 10px 12px;
        }

        .yp-review-btn {
            font-size: 13px;
        }

        /* Review list (if you enable the example block) */
        .yp-review-item {
            border-top: 1px solid #f0f0f0;
            padding-top: 12px;
            margin-top: 12px;
        }

        .yp-review-name {
            font-size: 13px;
            font-weight: 800;
            color: #111;
        }

        .yp-review-date {
            font-size: 12px;
            color: #777;
        }

        .yp-review-text {
            font-size: 13px;
            color: #333;
            line-height: 1.6;
        }



        /* Suggested Listings inside right card */
        .yp-suggested-title {
            font-size: 13px;
            font-weight: 800;
            color: #111;
        }

        .yp-suggested-card {
            display: block;
            text-decoration: none;
            border: 1px solid #f0f0f0;
            border-radius: 4px;
            padding: 10px 12px;
            margin-bottom: 10px;
            background: #fff;
        }

        .yp-suggested-card:hover {
            border-color: #e1e4ea;
            box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .06);
        }

        .yp-suggested-name {
            font-size: 13px;
            font-weight: 800;
            color: #111;
            margin-bottom: 4px;
        }

        .yp-suggested-meta {
            font-size: 12px;
            color: #777;
            line-height: 1.5;
        }

        .yp-suggested-btn {
            font-size: 13px;
        }


        /* Suggested card with thumbnail */
        .yp-suggested-card--media {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .yp-suggested-thumb {
            width: 54px;
            height: 54px;
            border-radius: 4px;
            overflow: hidden;
            background: #f5f5f5;
            flex: 0 0 54px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .yp-suggested-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .yp-suggested-thumb--placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
            font-size: 16px;
        }

        .yp-suggested-body {
            min-width: 0;
            /* prevents overflow */
        }
    </style>
@endpush

@section('pages')
    {{-- CATEGORY NAV STRIP --}}
    {{-- <div class="category-top-nav">
        <div class="container">
            @foreach ($topCategories as $cat)
                <a href="{{ route('frontend.category.show', $cat->slug) }}">
                    <i class="fa-solid fa-folder"></i> {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div> --}}
    <x-frontend.header />

    <main class="container mb-4">
        @if(session('success'))
            <div class="alert alert-success py-2 mb-3">
                {{ session('success') }}
            </div>
        @endif

        {{-- Breadcrumb --}}
        <div class="breadcrumb-custom">
            @foreach ($breadcrumb as $i => $bc)
                @if ($i > 0)
                    &gt;
                @endif
                <a style="color: #ff7a1a;" href="{{ $bc['url'] }}">{{ $bc['label'] }}</a>
            @endforeach
        </div>

        <div class="row">

            {{-- LEFT SIDEBAR --}}
            <div class="col-lg-3 order-2 order-lg-1 mt-3 mt-lg-0">

                {{-- Contact card --}}
                <div class="side-card">
                    @if ($listing->phone)
                        <div class="side-main-phone">{{ $listing->phone }}</div>
                    @endif

                    @if ($listing->website)
                        <a class="side-link-btn d-block text-decoration-none"
                            href="{{ \Illuminate\Support\Str::startsWith($listing->website, ['http://', 'https://']) ? $listing->website : 'https://' . $listing->website }}"
                            target="_blank">
                            <i class="fa-solid fa-globe" style="color:#ff7a1a;"></i>
                            <span style="color:#ff7a1a;">Visit Website</span>
                        </a>
                    @endif

                    @php
                        $addr =
                            optional($listing->address)->address_line ??
                            (optional($listing->address)->line2 ?? optional($listing->address)->line1);

                        $mapQ = trim(
                            ($listing->name ?? '') . ' ' . ($addr ?? '') . ' ' . (optional($listing->city)->name ?? ''),
                        );
                        $mapUrl = $mapQ ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($mapQ) : null;
                    @endphp

                    @if ($mapUrl)
                        <a class="side-link-btn d-block text-decoration-none" href="{{ $mapUrl }}" target="_blank">
                            <i class="fa-solid fa-location-dot" style="color:#ff7a1a;"></i>
                            <span style="color:#ff7a1a;">
                                {!! nl2br(e($addr)) !!}<br>

                            </span>
                        </a>
                    @endif

                </div>

                {{-- Claim business --}}
                <div class="side-card">
                    <div class="claim-box-title">Is this your business?</div>
                    <p class="mb-2">Customize this page.</p>
                    <a href="{{ route('listings.create') }}" class="btn w-100"
                        style="background-color:#ff7a1a; color:white;">Claim This
                        Business</a>
                </div>

                {{-- Hours --}}
                <div class="side-card">
                    <h5>Hours</h5>
                    <div class="hours-label">Regular Hours</div>

                    @if ($hoursByDay->count())
                        @foreach ($hoursByDay as $day => $rows)
                            <div class="hours-row">
                                <span>{{ $day }}:</span>
                                <span>{{ $rows->first()->formatted_range }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted" style="font-size:13px;">Hours not available</div>
                    @endif

                </div>

                {{-- Places near (dynamic based on same category) --}}
                <div class="side-card">
                    <h5>
                        Places Near {{ optional($listing->city)->name ?? 'your area' }}
                        with {{ optional($listing->category)->name ?? 'this category' }}
                    </h5>

                    @forelse($nearbyCities as $c)
                        <a href="#" class="places-link">{{ $c->name }}</a>
                    @empty
                        <div class="text-muted" style="font-size:13px;">No nearby places found</div>
                    @endforelse
                </div>
            </div>

            {{-- RIGHT CONTENT --}}
            <div class="col-lg-9 order-1 order-lg-2">

                {{-- Header --}}
                <div class="listing-header">
                    <div class="row g-3 align-items-start">
                        <div class="col-md-2 d-flex justify-content-center">
                            <div class="listing-thumb-main">
                                @php
                                    // ⚠️ if your photo column isn't "path", change it here
                                    $mainImg =
                                        optional($listing->primaryPhoto)->path ??
                                        (optional($listing->photos->first())->path ?? null);
                                @endphp

                                @if ($mainImg)
                                    <img style="object-fit:cover;" src="{{ asset('storage/' . $mainImg) }}"
                                        alt="{{ $listing->name }}">
                                @else
                                    <img src="{{ asset('placeholder.png') }}" alt="No Image">
                                @endif
                            </div>
                        </div>

                        <div class="col-md-10 text-md-start">
                            <div class="listing-main-title">{{ $listing->name }}</div>

                            <div class="listing-cats">
                                {{ optional($listing->category)->name ?? 'Uncategorized' }}
                                @if (optional($listing->category?->parent)->name)
                                    , {{ $listing->category->parent->name }}
                                @endif
                            </div>

                            <div class="mt-2 d-flex flex-wrap align-items-center">
                                <div class="rating-stars">
                                    {{-- simple star display from avg_rating --}}
                                    @php
                                        $avg = (float) ($listing->avg_rating ?? 0);
                                        $full = (int) floor($avg);
                                        $empty = 5 - $full;
                                    @endphp

                                    @for ($i = 0; $i < $full; $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                    @for ($i = 0; $i < $empty; $i++)
                                        <i class="fa-regular fa-star"></i>
                                    @endfor
                                </div>

                                @if ((int) $listing->review_count > 0)
                                    <a href="#" class="review-link ms-2">
                                        ({{ $listing->review_count }}) reviews
                                    </a>
                                    {{-- @else
                                    <a href="#" class="review-link ms-2">Be the first to review!</a> --}}
                                @endif
                            </div>

                            <div class="mt-2">
                                <span class="status-open">
                                    <i class="fa-solid fa-circle"></i>
                                    {{ strtoupper($listing->status ?? 'ACTIVE') }}
                                </span>
                            </div>

                            @if ($listing->tagline)
                                <div class="listing-meta-small mt-2">
                                    {{ $listing->tagline }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reviews (replaces Menu section) -->

                <div class="menu-section mb-3" id="reviews">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="menu-title">Reviews</div>

                        <button type="button" class="btn btn-outline-secondary btn-view-menu" data-bs-toggle="modal"
                            data-bs-target="#reviewModal">
                            <i class="fa-regular fa-pen-to-square me-1"></i> Write a Review
                        </button>
                    </div>

                    <!-- Reviews summary -->
                    <div class="listing-meta-small mb-2">
                        <i class="fa-regular fa-star"></i>
                        {{ $allApprovedCount }} Reviews
                        @if ($allApprovedCount == 0)
                            • Be the first to review!
                        @else
                            • Avg {{ number_format($avgRating, 1) }}
                        @endif
                    </div>

                    <div class="row g-3">
                        @forelse($latestReviews as $r)
                            <div class="col-md-4">
                                <div class="menu-card">
                                    <h6 class="d-flex justify-content-between align-items-center">
                                        <span><i class="fa-regular fa-user me-1"></i> {{ $r->name }}</span>
                                        <small class="text-muted">{{ $r->created_at->diffForHumans() }}</small>
                                    </h6>

                                    <div class="rating-stars mb-2" style="color:#f4b400;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= (int) $r->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>

                                    <div class="yp-paragraph mb-0">
                                        {{ \Illuminate\Support\Str::limit($r->comment, 140) }}
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="menu-card">
                                    <div class="yp-paragraph mb-0">
                                        No reviews yet. Be the first to review this business.
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    @if ($allApprovedCount > 3)
                        <a href="#reviews" class="btn btn-outline-secondary btn-view-menu mt-2">
                            <i class="fa-regular fa-star me-1"></i> View All Reviews
                        </a>
                    @endif
                </div>


                {{-- Gallery (dynamic from photos relation) --}}
                @php
                    $gallery = $listing->photos->take(3);
                    $totalPhotos = $listing->photos->count();
                @endphp

                <div class="gallery-section mb-5">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="gallery-title">
                            Gallery <small>View all ({{ $totalPhotos }})</small>
                        </div>

                    </div>

                    <div class="row g-2">
                        @forelse($gallery as $i => $photo)
                            @php
                                $p = $photo->path ?? null; // adjust if your column differs
                            @endphp
                            <div class="col-md-4 col-6 {{ $i === 2 ? 'd-none d-md-block' : '' }}">
                                <div class="gallery-thumb">
                                    @if ($p)
                                        <img src="{{ asset('storage/' . $p) }}" alt="Gallery {{ $i + 1 }}">
                                    @else
                                        <img src="{{ asset('placeholder.png') }}" alt="No Image">
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-muted" style="font-size:13px;">
                                    No photos uploaded yet.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Main Content -->
                <section class="col-12">
                    <div class="row g-3">
                        <!-- LEFT: More Info -->
                        <div class="col-lg-8">
                            <h4 class="yp-page-title mb-3">More Info</h4>

                            <div class="yp-info-wrap">

                                <!-- Serving Area -->
                                <div class="yp-info-block">
                                    <div class="yp-info-label">Serving Your Local Area</div>
                                    <div class="yp-info-value">

                                        <a class="btn btn-warning btn-sm fw-semibold" href="tel:{{ $listing->phone }}"
                                            style="background:#ff7a1a;border-color:#ff7a1a;color:#fff;">
                                            <i class="fa-solid fa-phone me-1"></i> Call Today
                                        </a>

                                    </div>
                                </div>



                                <!-- Email -->
                                <div class="yp-info-block">
                                    <div class="yp-info-label">Email</div>
                                    <div class="yp-info-value">
                                        <a class="yp-link" href="#"
                                            style="color:#ff7a1a;">{{ $listing->email }}</a>
                                    </div>
                                </div>

                                <!-- Services/Products -->
                                {{-- <div class="yp-info-block">
                            <div class="yp-info-label">Services/Products</div>
                            <div class="yp-info-value yp-paragraph">
                                Water Leaks, BBB, Kitchen &amp; Bath Plumbing, Complete Backhoe Service, Drain Cleaning,
                                Sewer Repair &amp; Replacement, Backflow Prevention, Boiler Repair &amp; Replacement,
                                Water Lines,
                                Electronic Leak Detection, Gas, Water Heaters, Gutter Cleaning, Serving Pittsburgh and
                                Surrounding Areas,
                                Sewer Video Inspection, Installation, Serving Pittsburgh And Surrounding Areas,
                                Emergency Service Available,
                                Dye Testing, Plumbing Contractors Commercial, Emergency Cleanup, Electric Snaker
                                Service, Rooter Service,
                                Sewer, Financing Available, Fully Insured, Sewer Lines, Gas, Emergency Plumber, Septic
                                Systems &amp; Tanks,
                                Kitchen Fixtures, Faucets, Sewer Lines &amp; Sewer Systems, Remodeling, Bathroom
                                Fixtures, Mechanical Services,
                                Plumbing Fixtures, Water Lines, Sewer, Air Conditioning, Fully Insured, Bathtubs &amp;
                                Showers, Heating, Gas,
                                Sewer Pumps, Gas, Water Heaters.
                            </div>
                        </div> --}}



                                <!-- Other Link -->
                                <div class="yp-info-block">
                                    <div class="yp-info-label">Other Link</div>
                                    <div class="yp-info-value">
                                        <a style="color: #ff7a1a;"
                                            href="{{ \Illuminate\Support\Str::startsWith($listing->website, ['http://', 'https://']) ? $listing->website : 'https://' . $listing->website }}"
                                            target="_blank" class="me-2 yp-link">{{ $listing->website }}</a>
                                    </div>
                                </div>

                                <!-- Social Links -->
                                <div class="yp-info-block">
                                    <div class="yp-info-label">Social Links</div>
                                    <div class="yp-info-value">
                                        <a class="yp-social" href="#" aria-label="Facebook"
                                            style="background-color:#ff7a1a;">
                                            <i class="fa-brands fa-facebook-f" style="color:#f8f6f5;"></i>
                                        </a>
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="yp-info-block">
                                    <div class="yp-info-label">Category</div>
                                    <div class="yp-info-value">
                                        <a class="yp-link" href="#"
                                            style="color:#ff7a1a;">{{ $listing->category->name }}</a>
                                    </div>
                                </div>

                                <!-- General Info -->
                                <div class="yp-info-block">
                                    <div class="yp-info-label">General Info</div>
                                    <div class="yp-info-value yp-paragraph">
                                        {!! nl2br(e(\Illuminate\Support\Str::words(strip_tags($listing->description), 300, '...'))) !!}

                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- RIGHT: Reviews -->
                        <div class="col-lg-4">
                            <div class="yp-reviews-card">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="yp-reviews-title">Reviews</div>

                                    <button type="button" class="btn btn-link p-0 yp-link yp-review-action"
                                        data-bs-toggle="modal" data-bs-target="#reviewModal">
                                        <i class="fa-regular fa-pen-to-square me-1"></i>Write
                                    </button>
                                </div>

                                <!-- Summary -->
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <div class="yp-review-score">{{ number_format($avgRating, 1) }}</div>
                                    <div>
                                        <div class="yp-review-stars" style="color:#f4b400;">
                                            @php $rounded = (int) round($avgRating); @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $rounded)
                                                    <i class="fa-solid fa-star"></i>
                                                @else
                                                    <i class="fa-regular fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <div class="yp-review-meta">
                                            {{ $allApprovedCount > 0 ? $allApprovedCount . ' reviews' : 'No reviews yet' }}
                                        </div>
                                    </div>
                                </div>

                                @if ($allApprovedCount == 0)
                                    <div class="yp-review-empty">
                                        Be the first to review this business.
                                    </div>
                                @endif

                                <button type="button" class="btn btn-outline-secondary w-100 mt-3 yp-review-btn"
                                    data-bs-toggle="modal" data-bs-target="#reviewModal">
                                    <i class="fa-regular fa-star me-1"></i> Write a Review
                                </button>

                                {{-- keep your Suggested Listings block below if you want --}}
                                <div class="yp-suggested-wrap mt-3">
                                    <div class="yp-suggested-title mb-2">Suggested Listings</div>

                                    @forelse($suggestedListings as $s)
                                        <a href="{{ route('frontend.listing.show', $s->slug) }}" class="yp-suggested-card yp-suggested-card--media">
                                            <div class="yp-suggested-thumb">
                                                @php
                                                    $img = $s->primaryPhoto?->path;
                                                @endphp

                                                @if($img)
                                                    <img src="{{ asset('storage/'.$img) }}" alt="{{ $s->primaryPhoto?->alt_text ?? $s->name }}">
                                                @else
                                                    <div class="yp-suggested-thumb--placeholder">
                                                        <i class="fa-regular fa-image"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="yp-suggested-body">
                                                <div class="yp-suggested-name">{{ $s->name }}</div>

                                                <div class="yp-suggested-meta">
                                                    <i class="fa-solid fa-location-dot me-1"></i>
                                                    {{ $s->city?->name ?? '—' }}
                                                </div>

                                                <div class="yp-suggested-meta">
                                                    <i class="fa-regular fa-star me-1"></i>
                                                    {{ number_format((float) ($s->avg_rating ?? 0), 1) }}
                                                    ({{ (int) ($s->review_count ?? 0) }} reviews)
                                                </div>
                                            </div>
                                        </a>
                                    @empty
                                        <div class="yp-review-empty">
                                            No suggested listings found in this category yet.
                                        </div>
                                    @endforelse

                                    @if($listing->category?->slug)
                                        <a href="{{ route('frontend.category.show', $listing->category->slug) }}"
                                        class="btn btn-outline-secondary w-100 mt-2 yp-suggested-btn">
                                            <i class="fa-solid fa-list me-1"></i> View More Listings
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>
                </section>


            </div>
        </div>

        <!-- Review Modal -->
        <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('listings.reviews.store', $listing->slug) }}">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title" id="reviewModalLabel">Write a Review</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Your Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Rating</label>

                                <input type="hidden" name="rating" id="reviewRating" value="{{ old('rating', 0) }}"
                                    required>

                                <div class="d-flex align-items-center gap-2">
                                    <div id="ratingStars" class="fs-5" style="color:#f4b400; cursor:pointer;">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa-regular fa-star" data-value="{{ $i }}"></i>
                                        @endfor
                                    </div>
                                    <small class="text-muted" id="ratingText">Select rating</small>
                                </div>

                                @error('rating')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-0">
                                <label class="form-label">Review</label>
                                <textarea name="comment" class="form-control" rows="4" required>{{ old('comment') }}</textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary"
                                style="background:#ff7a1a;border-color:#ff7a1a;">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        (function() {
            const ratingInput = document.getElementById('reviewRating');
            const starsWrap = document.getElementById('ratingStars');
            const ratingText = document.getElementById('ratingText');

            if (!ratingInput || !starsWrap) return;

            function paintStars(value) {
                const stars = starsWrap.querySelectorAll('i[data-value]');
                stars.forEach(star => {
                    const v = parseInt(star.getAttribute('data-value'), 10);
                    star.classList.toggle('fa-solid', v <= value);
                    star.classList.toggle('fa-regular', v > value);
                });
                ratingText.textContent = value ? `${value} / 5` : 'Select rating';
            }

            starsWrap.addEventListener('click', function(e) {
                const star = e.target.closest('i[data-value]');
                if (!star) return;
                const val = parseInt(star.getAttribute('data-value'), 10);
                ratingInput.value = val;
                paintStars(val);
            });

            // Load old value if validation failed
            const initial = parseInt(ratingInput.value || '0', 10);
            paintStars(initial);
        })();
    </script>
@endpush
