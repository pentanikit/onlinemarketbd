<!doctype html>
<html lang="bn">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $ad->title ?? 'Listing' }} • OnlineMarketBD</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('favicon.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Page CSS -->
    <style>
        /* OnlineMarketBD • Single Listing Page (Bikroy-style) */
        .slp-body {
            background: #eef2f5;
            font-family: "Trebuchet MS", Arial, sans-serif;
            color: #111;
        }

        /* breadcrumb */
        .slp-breadbar {
            background: #f7f9fb;
            border-bottom: 1px solid #e6edf4;
            padding: 10px 0;
        }

        .slp-breadcrumb {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
            font-size: 13px;
            color: #667085;
        }

        .slp-breadcrumb a {
            color: #0b66c3;
            font-weight: 800;
            text-decoration: none;
        }

        .slp-breadcrumb a:hover {
            text-decoration: underline;
        }

        .slp-bc-last {
            color: #111;
            font-weight: 900;
        }

        /* main */
        .slp-main {
            padding: 14px 0 26px;
        }

        /* top title row */
        .slp-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 14px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .slp-title {
            font-size: 26px;
            font-weight: 900;
            margin: 0;
            line-height: 1.15;
        }

        .slp-sub {
            color: #667085;
            font-size: 13px;
            margin-top: 6px;
        }

        .slp-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .slp-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 999px;
            border: 1px solid #e6edf4;
            background: #fff;
            color: #111;
            font-weight: 900;
            text-decoration: none;
            font-size: 13px;
        }

        .slp-action:hover {
            border-color: #d6e2ef;
            box-shadow: 0 10px 18px rgba(15, 23, 42, .06);
        }

        /* card */
        .slp-card {
            background: #fff;
            border: 1px solid #e6edf4;
            border-radius: 14px;
            padding: 14px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .05);
        }

        .slp-card-title {
            font-weight: 900;
            font-size: 15px;
            margin-bottom: 10px;
        }

        /* gallery */
        .slp-gallery-card {
            padding: 12px;
        }

        .slp-gallery {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .slp-mainimg-wrap {
            position: relative;
            width: 100%;
            border-radius: 12px;
            background: #f2f4f7;
            overflow: hidden;
            border: 1px solid #eef2f7;
        }

        .slp-mainimg {
            width: 100%;
            height: 420px;
            object-fit: contain;
            display: block;
            background: #fff;
        }

        .slp-nav {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            border: 1px solid #e6edf4;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: #111;
        }

        .slp-nav:hover {
            box-shadow: 0 10px 18px rgba(15, 23, 42, .06);
            border-color: #d6e2ef;
        }

        .slp-zoom {
            position: absolute;
            right: 10px;
            top: 10px;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 1px solid #e6edf4;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111;
        }

        .slp-zoom:hover {
            box-shadow: 0 10px 18px rgba(15, 23, 42, .06);
        }

        .slp-thumbs {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            overflow: auto;
            padding-bottom: 4px;
        }

        .slp-thumb {
            border: 2px solid transparent;
            border-radius: 12px;
            overflow: hidden;
            padding: 0;
            background: #fff;
            flex: 0 0 auto;
            width: 86px;
            height: 60px;
        }

        .slp-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .slp-thumb.is-active {
            border-color: #111;
        }

        /* price */
        .slp-price-card {
            padding: 14px;
        }

        .slp-price-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }

        .slp-price {
            font-size: 26px;
            font-weight: 900;
            color: #0e7b2f;
        }

        .slp-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .slp-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 999px;
            background: #fff3d6;
            border: 1px solid #ffe3a8;
            color: #8a5200;
            font-weight: 900;
            font-size: 12px;
        }

        .slp-chip-soft {
            background: #e7f0ff;
            border-color: #cfe0ff;
            color: #0b3b88;
        }

        .slp-specgrid {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .slp-spec {
            border: 1px solid #eef2f7;
            border-radius: 12px;
            padding: 10px 12px;
            background: #fbfdff;
        }

        .slp-spec span {
            display: block;
            font-size: 12px;
            color: #667085;
            font-weight: 800;
        }

        .slp-spec b {
            display: block;
            margin-top: 3px;
            font-weight: 900;
            color: #111;
        }

        /* description + kv */
        .slp-desc {
            color: #1f2937;
            font-size: 14px;
            line-height: 1.7;
        }

        .slp-kv {
            display: grid;
            gap: 10px;
        }

        .slp-kv-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid #eef2f7;
            border-radius: 12px;
            background: #fbfdff;
        }

        .slp-k {
            color: #667085;
            font-weight: 900;
        }

        .slp-v {
            font-weight: 900;
            color: #111;
            text-align: right;
        }

        /* seller card */
        .slp-seller-card {
            padding: 14px;
        }

        .slp-seller-head {
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .slp-seller-logo {
            width: 86px;
            height: 64px;
            border-radius: 10px;
            overflow: hidden;
            background: #111;
            border: 1px solid #e6edf4;
        }

        .slp-seller-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            background: #000;
        }

        .slp-seller-name {
            font-weight: 900;
            font-size: 16px;
        }

        .slp-seller-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .slp-mini {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            border: 1px solid transparent;
        }

        .slp-mini-gold {
            background: #fff3d6;
            color: #8a5200;
            border-color: #ffe3a8;
        }

        .slp-mini-blue {
            background: #e7f0ff;
            color: #0b3b88;
            border-color: #cfe0ff;
        }

        .slp-seller-since {
            margin-top: 6px;
            color: #667085;
            font-size: 12px;
            font-weight: 800;
        }

        .slp-seller-link {
            display: inline-block;
            margin-top: 6px;
            color: #0b66c3;
            font-weight: 900;
            text-decoration: none;
            font-size: 13px;
        }

        .slp-seller-link:hover {
            text-decoration: underline;
        }

        .slp-seller-actions {
            margin-top: 12px;
            display: grid;
            gap: 10px;
        }

        .slp-act {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 12px;
            border: 1px solid #eef2f7;
            border-radius: 12px;
            background: #fff;
            text-decoration: none;
            color: #111;
        }

        .slp-act:hover {
            border-color: #d6e2ef;
            box-shadow: 0 10px 18px rgba(15, 23, 42, .06);
        }

        .slp-act-ico {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111;
            background: #f4f7fb;
            font-size: 16px;
        }

        .slp-ico-phone {
            color: #0e7b2f;
        }

        .slp-ico-chat {
            color: #0b66c3;
        }

        .slp-ico-wa {
            color: #16a34a;
        }

        .slp-act-text b {
            font-weight: 900;
            display: block;
        }

        .slp-act-text small {
            color: #667085;
            font-weight: 800;
            display: block;
            margin-top: 2px;
        }

        /* safety */
        .slp-safety-title {
            font-weight: 900;
            font-size: 14px;
            margin-bottom: 10px;
            color: #0b3b88;
        }

        .slp-safety {
            border-left: 4px solid #0b66c3;
        }

        .slp-safety-list {
            margin: 0;
            padding-left: 18px;
            color: #374151;
            font-size: 13px;
            line-height: 1.7;
            font-weight: 800;
        }

        .slp-safety-link {
            display: inline-block;
            margin-top: 10px;
            color: #0b66c3;
            font-weight: 900;
            text-decoration: none;
        }

        .slp-safety-link:hover {
            text-decoration: underline;
        }

        /* modal */
        .slp-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .75);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            padding: 18px;
        }

        .slp-modal.is-open {
            display: flex;
        }

        .slp-modal-img {
            max-width: min(1100px, 96vw);
            max-height: 92vh;
            border-radius: 14px;
            background: #fff;
        }

        .slp-modal-close {
            position: fixed;
            right: 18px;
            top: 18px;
            width: 46px;
            height: 46px;
            border-radius: 14px;
            border: 0;
            background: #fff;
            font-size: 18px;
            font-weight: 900;
        }

        /* responsive */
        @media (max-width: 991px) {
            .slp-title {
                font-size: 22px;
            }

            .slp-mainimg {
                height: 340px;
            }
        }

        @media (max-width: 576px) {
            .slp-mainimg {
                height: 260px;
            }

            .slp-nav {
                width: 38px;
                height: 38px;
                border-radius: 12px;
            }

            .slp-thumb {
                width: 72px;
                height: 52px;
            }

            .slp-specgrid {
                grid-template-columns: 1fr;
            }

            .slp-kv-row {
                grid-template-columns: 1fr;
            }

            .slp-v {
                text-align: left;
            }
        }
    </style>
</head>

<body class="slp-body">

    {{-- Top breadcrumb --}}
    <div class="slp-breadbar">
        <div class="container">
            <nav class="slp-breadcrumb">
                <a href="{{ url('/') }}">Home</a>
                <span>›</span>
                <a href="">All Products</a>
                <span>›</span>
                <a href="">
                    {{ $ad->category_name ?? 'Electronics' }}
                </a>
                <span>›</span>
                <span class="slp-bc-last">{{ \Illuminate\Support\Str::limit($ad->title ?? '...', 40) }}</span>
            </nav>
        </div>
    </div>

    <main class="container slp-main">

        {{-- Title + actions --}}
        <div class="slp-top">
            <div class="slp-titlebox">
                <h1 class="slp-title">{{ $ad->name ?? 'Product Title' }}</h1>
                <div class="slp-sub">
                    Posted at
                    {{ isset($ad->created_at) ? \Carbon\Carbon::parse($ad->created_at)->format('d M, h:i A') : '—' }},
                    {{ $ad->location ?? 'Dhaka' }}
                </div>
            </div>

            <div class="slp-actions">
                <a class="slp-action" href="#"
                    onclick="navigator.share ? navigator.share({title: document.title, url: window.location.href}) : alert('Share not supported'); return false;">
                    <i class="fa-solid fa-share-nodes"></i> Share
                </a>
                <a class="slp-action" href="#">
                    <i class="fa-regular fa-bookmark"></i> Bookmark this
                </a>
            </div>
        </div>

        <div class="row g-3">
            {{-- LEFT: Gallery + details --}}
            <section class="col-12 col-lg-8">

                {{-- Gallery card --}}
                <div class="slp-card slp-gallery-card">
                    @php
                        // Expect: $images as array of URLs or paths
                        // If you store in DB: pass $images = $ad->images->pluck('path')->toArray();
                        $imgs = $images ?? [];
                        if (empty($imgs) && !empty($ad->image)) {
                            $imgs = [$ad->image];
                        }
                        if (empty($imgs)) {
                            $imgs = ['https://dummyimage.com/1200x800/f2f4f8/111&text=No+Image'];
                        }
                    @endphp

                    <div class="slp-gallery">
                        <button type="button" class="slp-nav slp-prev" id="slpPrev" aria-label="Prev">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <div class="slp-mainimg-wrap">
                            <img id="slpMainImg" class="slp-mainimg" src="{{ asset('storage/'.$imgs[0]) }}" alt="Main image">
                            <button type="button" class="slp-zoom" id="slpZoom" title="Fullscreen">
                                <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                            </button>
                        </div>

                        <button type="button" class="slp-nav slp-next" id="slpNext" aria-label="Next">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="slp-thumbs" id="slpThumbs">
                        @foreach ($imgs as $i => $p)
                            <button type="button" class="slp-thumb {{ $i === 0 ? 'is-active' : '' }}"
                                data-src="{{ asset('storage/'.$p) }}" aria-label="Thumbnail {{ $i + 1 }}">
                                <img src="{{ asset('storage/'.$p) }}" alt="Thumb {{ $i + 1 }}">
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- Price + quick specs --}}
                <div class="slp-card slp-price-card mt-3">
                    <div class="slp-price-row">
                        <div class="slp-price">
                            ৳ {{ number_format((float) ($ad->price ?? 0), 0) }}
                        </div>

                        <div class="slp-tags">
                            @if (($ad->condition ?? '') !== '')
                                <span class="slp-chip"><i class="fa-solid fa-circle-check me-1"></i>
                                    {{ $ad->condition }}</span>
                            @endif
                            @if (($ad->brand ?? '') !== '')
                                <span class="slp-chip slp-chip-soft"><i class="fa-solid fa-tag me-1"></i>
                                    {{ $ad->brand }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- <div class="slp-specgrid">
                        <div class="slp-spec"><span>কন্ডিশন</span><b>{{ $ad->condition ?? 'একেবারে নতুন' }}</b></div>
                        <div class="slp-spec"><span>ব্র্যান্ড</span><b>{{ $ad->brand ?? '—' }}</b></div>
                        <div class="slp-spec"><span>মডেল</span><b>{{ $ad->model ?? '—' }}</b></div>
                        <div class="slp-spec"><span>ক্যাটাগরি</span><b>{{ $ad->category_name ?? '—' }}</b></div>
                    </div> --}}
                </div>

                {{-- Description --}}
                <div class="slp-card mt-3">
                    <div class="slp-card-title">Details</div>
                    <div class="slp-desc">
                        {!! nl2br(e($ad->description ?? 'No description added.')) !!}
                    </div>
                </div>

                {{-- Optional: extra info list --}}
                @php
                    // If you have extra attributes/specs in DB, pass $specs as array:
                    // $specs = ['Display Type' => 'HD', 'Display Size' => 'Up to 32 inch'];
                    $specs = $specs ?? [];
                @endphp

                @if (!empty($specs))
                    <div class="slp-card mt-3">
                        <div class="slp-card-title">Specifications</div>
                        <div class="slp-kv">
                            @foreach ($specs as $k => $v)
                                <div class="slp-kv-row">
                                    <div class="slp-k">{{ $k }}</div>
                                    <div class="slp-v">{{ $v }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </section>

            {{-- RIGHT: Seller card + safety --}}
            <aside class="col-12 col-lg-4">

                @php
                    // Expect $shop or $seller object
                    $shopObj = $shop ?? null;
                    $sellerName = $shopObj->name ?? ($shopObj->shop_name ?? ($ad->seller_name ?? 'Seller'));
                    $sellerLogo = $shopObj->logo_path ?? null;
                    $memberSince = isset($shopObj->created_at)
                        ? \Carbon\Carbon::parse($shopObj->created_at)->format('M Y')
                        : null;
                    $phone = $shopObj->support_phone ?? ($ad->support_phone ?? '');
                    $masked =
                        $shopObj->support_phone ??
                        ($phone ? preg_replace('/(\d{5})\d+/', '$1XXXXXX', $phone) : '01851XXXXXX');
                @endphp

                <div class="slp-card slp-seller-card">
                    <div class="slp-seller-head">
                        <div class="slp-seller-logo">
                            <img src="{{ $sellerLogo ? asset('storage/'.$sellerLogo) : 'https://dummyimage.com/120x80/111/fff&text=LOGO' }}"
                                alt="Seller logo">
                        </div>

                        <div class="slp-seller-meta">
                            <div class="slp-seller-name">{{ $sellerName }}</div>
                            <div class="slp-seller-badges">
                                <span class="slp-mini slp-mini-gold"><i class="fa-solid fa-star me-1"></i> Top
                                    Seller</span>
                                <span class="slp-mini slp-mini-blue"><i class="fa-solid fa-circle-check me-1"></i>
                                    Verified</span>
                            </div>

                            <div class="slp-seller-since">
                                @if ($memberSince)
                                    Member {{ $memberSince }} since
                                @endif
                            </div>

                            <a class="slp-seller-link"
                                href="{{ route('shops.show', $shopObj->slug ?? ($shopObj->id ?? null)) ?? '#' }}">
                                View all products of this seller
                            </a>
                        </div>
                    </div>

                    <div class="slp-seller-actions">
                        <a class="slp-act" href="{{ $phone ? 'tel:' . $phone : '#' }}">
                            <span class="slp-act-ico slp-ico-phone"><i class="fa-solid fa-phone"></i></span>
                            <span class="slp-act-text">
                                <b>{{ $masked }}</b>
                                <small>Click to see phone</small>
                            </span>
                        </a>

                        {{-- <a class="slp-act" href="{{ route('messages.create', $shopObj->id ?? null) ?? '#' }}">
                            <span class="slp-act-ico slp-ico-chat"><i class="fa-solid fa-comment-dots"></i></span>
                            <span class="slp-act-text">
                                <b>চ্যাট</b>
                                <small>সেলারকে মেসেজ করুন</small>
                            </span>
                        </a> --}}

                        <a class="slp-act"
                            href="{{ $phone ? 'https://wa.me/88' . preg_replace('/\D+/', '', $phone) : '#' }}"
                            target="_blank">
                            <span class="slp-act-ico slp-ico-wa"><i class="fa-brands fa-whatsapp"></i></span>
                            <span class="slp-act-text">
                                <b>Whatsapp</b>
                                <small>WhatsApp এ কথা বলুন</small>
                            </span>
                        </a>
                    </div>
                </div>

                {{-- <div class="slp-card slp-safety mt-3">
                    <div class="slp-safety-title">
                        <i class="fa-solid fa-shield-halved me-2"></i>
                        সতর্ক থাকুন: অনলাইন স্ক্যাম এড়িয়ে চলুন
                    </div>

                    <ul class="slp-safety-list">
                        <li>কখনই বাইরে গিয়ে মেসেজ পাঠাবেন না</li>
                        <li>OTP / কার্ডের তথ্য শেয়ার করবেন না</li>
                        <li>অগ্রিম টাকা না দিয়ে যাচাই করে নিন</li>
                        <li>লোকেশন ও ডেলিভারি আগে নিশ্চিত করুন</li>
                    </ul>

                    <a class="slp-safety-link" href="#">সবগুলো সেফটি টিপস দেখুন</a>
                </div> --}}

            </aside>
        </div>
    </main>

    {{-- Fullscreen modal (simple) --}}
    <div class="slp-modal" id="slpModal" aria-hidden="true">
        <button class="slp-modal-close" id="slpModalClose" type="button" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <img id="slpModalImg" class="slp-modal-img" src="" alt="Fullscreen image">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            const thumbsWrap = document.getElementById('slpThumbs');
            const mainImg = document.getElementById('slpMainImg');
            const thumbs = Array.from(document.querySelectorAll('.slp-thumb'));
            const prevBtn = document.getElementById('slpPrev');
            const nextBtn = document.getElementById('slpNext');

            const zoomBtn = document.getElementById('slpZoom');
            const modal = document.getElementById('slpModal');
            const modalImg = document.getElementById('slpModalImg');
            const modalClose = document.getElementById('slpModalClose');

            let index = 0;

            function setActive(i) {
                if (!thumbs.length) return;
                index = Math.max(0, Math.min(i, thumbs.length - 1));

                thumbs.forEach(t => t.classList.remove('is-active'));
                thumbs[index].classList.add('is-active');

                const src = thumbs[index].getAttribute('data-src');
                mainImg.src = src;

                // keep active thumb visible
                thumbs[index].scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'nearest'
                });
            }

            thumbs.forEach((btn, i) => {
                btn.addEventListener('click', () => setActive(i));
            });

            prevBtn?.addEventListener('click', () => setActive(index - 1));
            nextBtn?.addEventListener('click', () => setActive(index + 1));

            document.addEventListener('keydown', (e) => {
                if (modal.classList.contains('is-open')) {
                    if (e.key === 'Escape') closeModal();
                    if (e.key === 'ArrowLeft') setActive(index - 1);
                    if (e.key === 'ArrowRight') setActive(index + 1);
                    return;
                }
                if (e.key === 'ArrowLeft') setActive(index - 1);
                if (e.key === 'ArrowRight') setActive(index + 1);
            });

            function openModal() {
                modalImg.src = mainImg.src;
                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');
            }

            function closeModal() {
                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');
            }

            zoomBtn?.addEventListener('click', openModal);
            mainImg?.addEventListener('dblclick', openModal);
            modalClose?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            // init
            setActive(0);
        })();
    </script>

</body>

</html>
