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

        /* Header (same as previous page) */
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

        /* Yellow global search bar */
        .header-search-bar {
            background-color: #f5f4f3;
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

        /* Category nav strip under yellow bar */
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

        /* Listing page main */
        .breadcrumb-custom {
            font-size: 12px;
            color: #777;
            margin-top: 16px;
            margin-bottom: 4px;
        }

        .breadcrumb-custom a {
            color: #0073bb;
            text-decoration: none;
        }

        .breadcrumb-custom a:hover {
            text-decoration: underline;
        }

        .listing-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .filter-buttons .btn {
            border-radius: 20px;
            font-size: 13px;
            padding: 7px 14px;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .filter-buttons .btn-outline-secondary {
            border-color: #d0d4db;
            color: #555;
        }

        .filter-buttons .btn-outline-secondary:hover {
            background-color: #f2f4f8;
        }

        .view-open-bar {
            background-color: #f7fbff;
            border: 1px solid #dce5f0;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 13px;
            margin-top: 10px;
        }

        .view-open-bar i {
            color: #22a05d;
            margin-right: 6px;
        }

        /* menu search */
        .menu-search-bar {
            margin-top: 16px;
            margin-bottom: 14px;
        }

        .menu-search-bar .form-control {
            font-size: 13px;
        }

        .menu-search-bar .btn {
            font-size: 13px;
            font-weight: 600;
        }

        /* listing card */
        .listing-card {
            border: 1px solid #e1e4ea;
            border-radius: 4px;
            padding: 14px 16px;
            margin-bottom: 12px;
            background-color: #fff;
        }

        .listing-thumb {
            width: 110px;
            height: 110px;
            border-radius: 3px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .listing-thumb img {
            max-width: 100%;
            max-height: 100%;
        }

        .listing-name {
            font-size: 18px;
            font-weight: 700;
            color: #0073bb;
        }

        .listing-name a {
            color: inherit;
            text-decoration: none;
        }

        .listing-name a:hover {
            text-decoration: underline;
        }

        .listing-cats {
            font-size: 13px;
            color: #555;
        }

        .listing-meta {
            font-size: 12px;
            color: #777;
        }

        .listing-meta i {
            margin-right: 4px;
        }

        .listing-desc {
            font-size: 13px;
            color: #555;
            margin-top: 6px;
        }

        .btn-order {
            background-color: #0073bb;
            border-color: #0073bb;
            font-size: 13px;
            padding: 7px 16px;
        }

        .listing-right {
            text-align: right;
            font-size: 13px;
        }

        .listing-phone {
            font-weight: 700;
        }

        .listing-address {
            margin-top: 4px;
            color: #555;
        }

        .badge-status-closed {
            color: #d93025;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 11px;
        }

        /* Sidebar */
        .side-card {
            border: 1px solid #e1e4ea;
            border-radius: 4px;
            padding: 14px 16px;
            margin-bottom: 12px;
            background-color: #fff;
        }

        .side-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .side-link {
            display: block;
            font-size: 13px;
            text-decoration: none;
            color: #0073bb;
            margin-bottom: 6px;
        }

        .side-link:hover {
            text-decoration: underline;
        }

        .side-cuisine-icon {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background-color: #f4f6fb;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 6px;
        }

        .side-manage-title {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .side-manage-title span {
            font-weight: 700;
            text-decoration: underline;
            text-decoration-color: #ffeb3b;
        }

        .side-manage-text {
            font-size: 13px;
            color: #555;
            margin-bottom: 10px;
        }

        .side-btn-primary {
            background-color: #0073bb;
            border-color: #0073bb;
            font-size: 13px;
            padding: 7px 16px;
            font-weight: 600;
        }

        .side-phone-text {
            font-size: 12px;
            margin-top: 8px;
        }

        .side-phone-text span {
            font-weight: 700;
        }

        .side-featured-entry {
            font-size: 13px;
            margin-bottom: 8px;
        }

        .side-featured-entry strong {
            display: block;
        }

        /* Footer small (simpler than previous big footer) */
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

            .listing-right {
                text-align: left;
                margin-top: 8px;
            }

            .listing-card {
                padding: 12px;
            }
        }
    </style>
@endpush

@section('pages')
    <x-frontend.header />
    @php
        $content = \App\Models\SiteContent::where('key', 'home')->first();

     @endphp
    <!-- CATEGORY NAV STRIP -->
    {{-- <div class="category-top-nav filter-buttons">
        <div class="container">
            @foreach ($subCategories as $cat)

                <a href="{{ route('frontend.category.show', $cat->slug) }}">
                    <button class="btn btn-outline-secondary"><i class="fa-solid fa-folder"></i>{{ $cat->name }}</button>
                </a>
            @endforeach
        </div>
    </div> --}}

    {{-- <div class="filter-buttons">
        <div class="container">
            @foreach ($subCategories as $cat)
                <a href="{{ route('frontend.category.show', $cat->slug) }}">
                    <button class="btn btn-outline-secondary">{{ $cat->name }}</button>
                </a>
            @endforeach
        </div>


    </div> --}}

    <!-- MAIN CONTENT -->
    <main class="container mb-4">
        <!-- Breadcrumb / title -->
        <div class="breadcrumb-custom">
            @foreach ($breadcrumb as $i => $bc)
                @if ($i > 0)
                    &gt;
                @endif
                <a style="color: #ff7a1a;" href="{{ $bc['url'] }}">{{ $bc['label'] }}</a>
            @endforeach
        </div>

        <h1 class="listing-title">
            {{ $category->name }}
            @if (optional($listings)->total())
                <span style="font-size:14px; font-weight:600; color:#666;">({{ $listings->total() }})</span>
            @endif
        </h1>

        <div class="row">
            <!-- Left: listings -->
            <div class="col-lg-8">

                {{-- Menu search (search inside this category) --}}
                <div class="menu-search-bar">
                    <form method="GET" action="{{ route('frontend.category.show', $category->slug) }}">
                        <div class="input-group">
                            <input type="text" class="form-control" name="q" value="{{ $q }}"
                                placeholder="Find your business">
                            <button class="btn" style="background-color: #ff7921; color:white; font-weight:700;" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Find</button>
                        </div>
                    </form>
                </div>

                {{-- Listings loop --}}
                @forelse($listings as $index => $listing)
                    <div class="listing-card">
                        <div class="row">
                            <div class="col-md-2 d-flex justify-content-center">
                                <div class="listing-thumb">
                                    @php
                                        $img = optional($listing->primaryPhoto)->path ?? null; // adjust if needed
                                    @endphp

                                    @if ($img)
                                        <img src="{{ asset('storage/'.$img) }}" alt="{{ $listing->name }}">
                                    @else
                                        <img src="{{ asset('placeholder.png') }}" alt="No Image">
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="listing-name">
                                    <a href="{{ route('frontend.listing.show', $listing->slug) }}">
                                        {{ $listings->firstItem() + $index }}. {{ $listing->name }}
                                    </a>
                                </div>

                                <div class="listing-cats">
                                    {{ optional($listing->category)->name }}
                                    @if (optional($listing->city)->name)
                                        , {{ $listing->city->name }}
                                    @endif
                                </div>

                                <div class="listing-meta mt-1">
                                    @if ($listing->website)
                                        <a style="color: #ff7a1a;" href="{{ \Illuminate\Support\Str::startsWith($listing->website, ['http://','https://']) ? $listing->website : 'https://'.$listing->website }}" target="_blank" class="me-2">Website</a>
                                    @endif

                                    @if ($listing->review_count)
                                        <span class="ms-1">
                                            <i class="fa-regular fa-star"></i>
                                            ({{ $listing->review_count }})
                                        </span>
                                    @endif
                                </div>

                                @if ($listing->tagline || $listing->description)
                                    <p class="listing-desc">
                                        {{ \Illuminate\Support\Str::limit($listing->tagline ?: strip_tags($listing->description), 160) }}
                                    </p>
                                @endif

                                <a href="{{ route('frontend.listing.show', $listing->slug) }}" class="btn" style="background-color: #ff7a1a; color:white;">View Details</a>
                            </div>

                            <div class="col-md-4 listing-right">
                                @if ($listing->phone)
                                    <div class="listing-phone">{{ $listing->phone }}</div>
                                @endif

                                <div class="listing-address">
                                    @if (optional($listing->address)->address_line)
                                        {{ $listing->address->address_line }}<br>
                                    @endif
                                    @if (optional($listing->city)->name)
                                        {{ $listing->city->name }}
                                    @endif
                                </div>

                                <div class="mt-2 badge-status-closed">
                                    {{ strtoupper($listing->status) }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="listing-card">
                        <strong>No listings found</strong>
                        <div class="text-muted" style="font-size:13px;">
                            Try a different keyword or check another category.
                        </div>
                    </div>
                @endforelse

                {{-- Pagination --}}
                <div class="mt-3">
                    {{ $listings->links() }}
                </div>
            </div>

            <!-- Right sidebar -->
            <div class="col-lg-4 mt-3 mt-lg-0">

                <!-- Popular Cuisines (sub categories) -->
                <div class="side-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="side-title">
                            {{ $currentParent->name }} Categories
                        </div>
                    </div>

                    @forelse($subCategories as $sub)
                        <a href="{{ route('frontend.category.show', $sub->slug) }}" class="side-link" style="color: black;">
                            <span class="side-cuisine-icon"><i class="fa-solid fa-tag" style="color: #ff7a1a;"></i></span>
                            {{ $sub->name }}
                        </a>
                    @empty
                        <div class="text-muted" style="font-size:13px;">No subcategories</div>
                    @endforelse
                </div>

                <!-- Manage free listing (static) -->
                <div class="side-card">
                    <div class="side-manage-title">
                        Manage your <span>free</span> listing
                    </div>
                    <p class="side-manage-text">
                        Update your business information in a few steps. Make it easy for your customers to find you.
                    </p>
                    <a href="{{ $content->manage_cta_url }}" class="btn listing-btn" style="background-color: #ff7a1a; color:white; font-weight:700;">
                        {{ $content->manage_cta_text }}
                    </a>

                    <div class="side-phone-text" style="font-size: 22px;">
                        <span style="font-weight:700;">C</span>all : <span>{{ $content->manage_phone }}</span>
                    </div>
                </div>

                <!-- Featured listings -->
                <div class="side-card">
                    <div class="side-title">Featured {{ $category->name }}</div>

                    @forelse($featured as $f)
                        <div class="side-featured-entry">
                            <strong>{{ $f->name }}</strong>
                            @if ($f->phone)
                                <span>{{ $f->phone }}</span>
                            @endif
                            <span>{{ optional($f->category)->name }}</span>
                        </div>
                    @empty
                        <div class="text-muted" style="font-size:13px;">No featured listings yet.</div>
                    @endforelse
                </div>

            </div>
        </div>
    </main>
@endsection
