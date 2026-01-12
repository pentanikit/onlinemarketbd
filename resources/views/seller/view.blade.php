<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $shop->name ?? 'Shop' }} • OnlineMarketBD</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Page CSS -->
    <style>
        /* OnlineMarketBD • Shop View (Bikroy-style) */
        .omsv-body {
            background: #eef2f5;
            font-family: "Trebuchet MS", Arial, sans-serif;
            color: #111;
        }

        /* Topbar */
        .omsv-topbar {
            background: #ffffff;
            border-bottom: 1px solid #e7edf4;
        }

        .omsv-topbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 12px;
        }

        .omsv-brand {
            font-weight: 900;
            text-decoration: none;
            color: #111;
            letter-spacing: .2px;
        }

        .omsv-top-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .omsv-topbtn {
            border-radius: 12px;
        }

        /* Cover */
        .omsv-cover {
            padding: 14px 0 0;
        }

        .omsv-cover-wrap {
            position: relative;
            border-radius: 14px;
            overflow: hidden;
            background: #dfe6ee;
            min-height: 220px;
        }

        .omsv-cover-img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            display: block;
        }

        .omsv-cover-watermark {
            position: absolute;
            right: 20px;
            bottom: 18px;
            font-weight: 900;
            font-size: 72px;
            letter-spacing: .6px;
            color: rgba(255, 255, 255, .35);
            user-select: none;
            pointer-events: none;
        }

        /* Logo overlay */
        .omsv-logo-box {
            position: absolute;
            left: 18px;
            bottom: 18px;
            width: 240px;
            max-width: 70%;
            background: #0f1114;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 12px 26px rgba(0, 0, 0, .18);
        }

        .omsv-logo {
            width: 100%;
            height: 130px;
            object-fit: contain;
            display: block;
            background: #000;
            border-radius: 8px;
        }

        .omsv-logo-sub {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .omsv-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            background: #ffdf8a;
            color: #111;
        }

        .omsv-chip-soft {
            background: #e7f0ff;
            color: #0b3b88;
        }

        /* Main */
        .omsv-main {
            padding: 14px 0 24px;
        }

        /* Cards */
        .omsv-card {
            background: #fff;
            border: 1px solid #e7edf4;
            border-radius: 14px;
            padding: 16px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .05);
        }

        .omsv-shop-title {
            font-weight: 900;
            font-size: 20px;
        }

        .omsv-shop-tagline {
            color: #58606a;
            margin-top: 2px;
        }

        .omsv-meta-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .omsv-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            border: 1px solid transparent;
        }

        .omsv-badge-gold {
            background: #fff3d6;
            color: #8a5200;
            border-color: #ffe3a8;
        }

        .omsv-badge-blue {
            background: #e7f0ff;
            color: #0b3b88;
            border-color: #cfe0ff;
        }

        .omsv-divider {
            height: 1px;
            background: #edf2f7;
            margin: 14px 0;
        }

        .omsv-info-line {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 6px 0;
        }

        .omsv-info-k {
            color: #58606a;
            font-weight: 800;
            font-size: 13px;
        }

        .omsv-info-v {
            font-weight: 900;
        }

        .omsv-hours-title {
            font-weight: 900;
            color: #0e5f2a;
        }

        .omsv-link {
            color: #0b66c3;
            text-decoration: none;
            font-weight: 800;
        }

        .omsv-link:hover {
            text-decoration: underline;
        }

        .omsv-action {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 12px 10px;
            border-radius: 12px;
            border: 1px solid #eef2f7;
            background: #fff;
            text-decoration: none;
            color: #111;
            margin-top: 10px;
        }

        .omsv-action:hover {
            border-color: #dce6f3;
            box-shadow: 0 10px 18px rgba(15, 23, 42, .05);
        }

        .omsv-action-ico {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f4f7fb;
            color: #111;
            font-size: 16px;
        }

        .omsv-action-title {
            font-weight: 900;
        }

        .omsv-action-sub {
            color: #58606a;
            font-size: 12px;
            margin-top: 1px;
        }

        .omsv-tip {
            border-radius: 14px;
            padding: 16px;
            background: #111;
            color: #fff;
        }

        .omsv-tip-title {
            font-weight: 900;
        }

        .omsv-tip-text {
            color: rgba(255, 255, 255, .85);
            margin-top: 6px;
            font-size: 13px;
        }

        /* Search */
        .omsv-searchbar {
            background: #fff;
            border: 1px solid #e7edf4;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .05);
        }

        .omsv-searchgroup {
            border: 1px solid #e7edf4;
            border-radius: 999px;
            overflow: hidden;
        }

        .omsv-searchinput {
            border: 0 !important;
            padding: 12px 16px;
        }

        .omsv-searchinput:focus {
            box-shadow: none !important;
        }

        .omsv-searchbtn {
            background: #f6b500;
            color: #111;
            font-weight: 900;
            padding: 0 18px;
            border: 0;
        }

        .omsv-searchhint {
            margin-top: 10px;
            font-weight: 900;
            color: #111;
        }

        /* Listing */
        .omsv-list {
            margin-top: 12px;
            display: grid;
            gap: 12px;
        }

        .omsv-item {
            display: flex;
            gap: 14px;
            align-items: stretch;
            background: #fff;
            border: 2px solid #ffd79a;
            /* orange-ish */
            border-radius: 10px;
            padding: 12px;
            text-decoration: none;
            color: #111;
        }

        .omsv-item:hover {
            border-color: #f6b500;
            box-shadow: 0 14px 26px rgba(15, 23, 42, .06);
        }

        .omsv-item-img {
            width: 130px;
            min-width: 130px;
            border-radius: 10px;
            overflow: hidden;
            background: #f2f4f7;
            border: 1px solid #eef2f7;
        }

        .omsv-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .omsv-item-body {
            flex: 1;
            min-width: 0;
        }

        .omsv-item-title {
            font-weight: 900;
            font-size: 16px;
            line-height: 1.25;
        }

        .omsv-item-meta {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 6px;
            color: #58606a;
            font-size: 13px;
        }

        .omsv-mini {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 800;
        }

        .omsv-mini-verified {
            color: #0e5f2a;
        }

        .omsv-mini-featured {
            color: #7a3a00;
        }

        .omsv-item-price {
            margin-top: 10px;
            font-weight: 900;
            color: #0e7b2f;
            font-size: 16px;
        }

        /* Right side icons */
        .omsv-item-side {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: space-between;
            min-width: 60px;
        }

        .omsv-side-icons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 2px;
        }

        .omsv-ico {
            width: 34px;
            height: 34px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #fff;
            border: 1px solid #e7edf4;
            color: #d97706;
        }

        .omsv-side-bubble {
            width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid #e7edf4;
            color: #e11d48;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
        }

        /* Empty */
        .omsv-empty {
            background: #fff;
            border: 1px dashed #dbe3ee;
            border-radius: 14px;
            padding: 24px;
            text-align: center;
        }

        .omsv-empty-title {
            font-weight: 900;
        }

        .omsv-empty-sub {
            color: #58606a;
            margin-top: 6px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .omsv-cover-img {
                height: 220px;
            }

            .omsv-cover-watermark {
                font-size: 46px;
            }

            .omsv-logo-box {
                width: 220px;
            }
        }

        @media (max-width: 576px) {
            .omsv-cover-img {
                height: 200px;
            }

            .omsv-cover-watermark {
                display: none;
            }

            .omsv-logo-box {
                left: 12px;
                bottom: 12px;
                width: 190px;
            }

            .omsv-logo {
                height: 110px;
            }

            .omsv-item {
                gap: 10px;
                padding: 10px;
            }

            .omsv-item-img {
                width: 110px;
                min-width: 110px;
            }

            .omsv-item-title {
                font-size: 15px;
            }
        }
    </style>
</head>

<body class="omsv-body">

    {{-- Top (optional) --}}
    <div class="omsv-topbar">
        <div class="container omsv-topbar-inner">
            <a class="omsv-brand" href="{{ url('/') }}">OnlineMarketBD</a>

            <div class="omsv-top-actions">
                <a class="btn btn-sm btn-outline-dark omsv-topbtn" href="{{ url('/') }}">
                    <i class="fa-solid fa-house me-1"></i> Home
                </a>
                <a class="btn btn-sm btn-dark omsv-topbtn" href="{{ route('seller.dashboard') ?? '#' }}">
                    <i class="fa-solid fa-store me-1"></i> Seller Panel
                </a>
            </div>
        </div>
    </div>

    {{-- Cover --}}
    <section class="omsv-cover">
        <div class="container">
            <div class="omsv-cover-wrap">

                <img class="omsv-cover-img"
                    src="{{ asset('storage/'.$shop->banner_path) ? asset('storage/'.$shop->banner_path) : 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=1800&auto=format&fit=crop' }}"
                    alt="Shop cover">

                <div class="omsv-cover-watermark">OnlineMarketBD</div>

                <div class="omsv-logo-box">
                    <img class="omsv-logo"
                        src="{{ asset('storage/'.$shop->logo_path) ? asset('storage/'.$shop->logo_path) : 'https://dummyimage.com/240x140/111/fff&text=LOGO' }}"
                        alt="Shop logo">
                    <div class="omsv-logo-sub">
                        <span class="omsv-chip"><i class="fa-solid fa-circle-check me-1"></i> Verified</span>
                        <span class="omsv-chip omsv-chip-soft"><i class="fa-solid fa-bolt me-1"></i> Trusted
                            Seller</span>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Content --}}
    <main class="container omsv-main">
        <div class="row g-3">

            {{-- Left: Shop Info --}}
            <aside class="col-12 col-lg-4">
                <div class="omsv-card">
                    <div class="omsv-shop-title">{{ $shop->name ?? 'Shop Name' }}</div>
                    <div class="omsv-shop-tagline">{{ $shop->tagline ?? 'Best product best service' }}</div>

                    <div class="omsv-meta-row mt-2">
                        <span class="omsv-badge omsv-badge-gold">
                            <i class="fa-solid fa-star me-1"></i> Top seller
                        </span>
                        <span class="omsv-badge omsv-badge-blue">
                            <i class="fa-solid fa-shield-halved me-1"></i> Buyer safe
                        </span>
                    </div>

                    <div class="omsv-divider"></div>

                    <div class="omsv-info-line">
                        <div class="omsv-info-k">Member since</div>
                        <div class="omsv-info-v">
                            {{ isset($shop->created_at) ? \Carbon\Carbon::parse($shop->created_at)->format('M Y') : '—' }}
                        </div>
                    </div>

                    <div class="omsv-info-line">
                        <div class="omsv-info-k"><i class="fa-solid fa-eye me-2"></i> Views</div>
                        <div class="omsv-info-v">{{ number_format((int) ($shop->views ?? 0)) }}</div>
                    </div>

                    <div class="omsv-divider"></div>

                    <div class="omsv-hours">
                        <div class="omsv-hours-title">
                            <i class="fa-regular fa-clock me-2"></i>
                            {{ $shop->hours_text ?? 'Open • Closes 9:00 PM' }}
                        </div>
                        <a class="omsv-link" href="#hours">See all hours</a>
                    </div>

                    <div class="omsv-divider"></div>

                    <a class="omsv-action" href="tel:{{ $shop->support_phone ?? '' }}">
                        <div class="omsv-action-ico"><i class="fa-solid fa-phone"></i></div>
                        <div class="omsv-action-text">
                            <div class="omsv-action-title">{{ $shop->support_phone ?? ($shop->support_phone ?? '018XXXXXXXX') }}
                            </div>
                            <div class="omsv-action-sub">Tap to call seller</div>
                        </div>
                    </a>

                    {{-- <a class="omsv-action" href="">
                        <div class="omsv-action-ico"><i class="fa-regular fa-envelope"></i></div>
                        <div class="omsv-action-text">
                            <div class="omsv-action-title">Send message</div>
                            <div class="omsv-action-sub">Chat with seller</div>
                        </div>
                    </a> --}}

                    <div class="omsv-action">
                        <div class="omsv-action-ico"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="omsv-action-text">
                            <div class="omsv-action-title">{{ $shop->address->address ?? 'Dhaka, Bangladesh' }}</div>
                            <div class="omsv-action-sub">
                                <a class="omsv-link" target="_blank"
                                    href="https://www.google.com/maps?q={{ urlencode($shop->address ?? 'Dhaka') }}">
                                    View on map
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="omsv-tip mt-3">
                    <div class="omsv-tip-title">Pro tip</div>
                    <div class="omsv-tip-text">
                        Always check product condition + delivery area before confirming order.
                    </div>
                </div>
            </aside>

            {{-- Right: Search + Listings --}}
            <section class="col-12 col-lg-8">

                {{-- Search bar --}}
                <div class="omsv-searchbar">
                    <form method="GET" action="">
                        <div class="input-group omsv-searchgroup">
                            <input type="text" name="q" value="{{ request('q') }}"
                                class="form-control omsv-searchinput"
                                placeholder="Search in this shop... (ex: Samsung, TV, Remote)">

                            <button class="btn omsv-searchbtn" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>

                        <div class="omsv-searchhint">
                            {{ $shop->name ?? 'Shop' }} listings
                            <span class="text-muted">
                                ({{ method_exists($ads, 'total') ? $ads->total() : (is_countable($ads) ? count($ads) : 0) }})
                            </span>
                        </div>
                    </form>
                </div>

                {{-- Listings --}}
                <div class="omsv-list">
                    @forelse($ads as $ad)
                        @php
                            $title = $ad->title ?? ($ad->name ?? 'Product title');
                            $img = $ad->primaryImage->path ?? ($ad->primaryImage->path ?? null);
                            $price = $ad->price ?? 0;
                            $location = $ad->location ?? ($shop->city ?? 'Dhaka');
                            $cat = $ad->category_name ?? ($ad->category ?? 'Category');
                            $isVerified = (bool) ($ad->is_verified ?? true);
                            $isFeatured = (bool) ($ad->is_featured ?? false);
                        @endphp

                        <a class="omsv-item" href="{{ route('product.view', $ad->slug) }}">
                            <div class="omsv-item-img">
                                <img src="{{ $img ? asset('storage/'.$img) : 'https://dummyimage.com/320x220/f2f4f8/111&text=Image' }}"
                                    alt="{{ $title }}">
                            </div>

                            <div class="omsv-item-body">
                                <div class="omsv-item-title">{{ $title }}</div>

                                <div class="omsv-item-meta">
                                    <span class="omsv-mini">
                                        <i class="fa-solid fa-tag me-1"></i> {{ $cat }}
                                    </span>
                                    <span class="omsv-mini">
                                        <i class="fa-solid fa-location-dot me-1"></i> {{ $location }}
                                    </span>

                                    @if ($isVerified)
                                        <span class="omsv-mini omsv-mini-verified">
                                            <i class="fa-solid fa-circle-check me-1"></i> Verified
                                        </span>
                                    @endif

                                    @if ($isFeatured)
                                        <span class="omsv-mini omsv-mini-featured">
                                            <i class="fa-solid fa-crown me-1"></i> Featured
                                        </span>
                                    @endif
                                </div>

                                <div class="omsv-item-price">
                                    Tk {{ number_format((float) $price, 0) }}
                                </div>
                            </div>

                            <div class="omsv-item-side">
                                <div class="omsv-side-icons">
                                    <span class="omsv-ico" title="Boost"><i class="fa-solid fa-arrow-up"></i></span>
                                    <span class="omsv-ico" title="Save"><i
                                            class="fa-regular fa-bookmark"></i></span>
                                </div>

                            </div>
                        </a>
                    @empty
                        <div class="omsv-empty">
                            <div class="omsv-empty-title">No listings found</div>
                            <div class="omsv-empty-sub">Try a different keyword.</div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination (Laravel paginator) --}}
                @if (method_exists($ads, 'links'))
                    <div class="mt-3">
                        {{ $ads->withQueryString()->links() }}
                    </div>
                @endif

            </section>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
