@once
    @push('styles')
        <style>
            /* ===== Shop Category Section (Frontpage match) ===== */
            .shopcat-wrap {
                background: #fff;
                padding: 8px 0 10px;
            }

            .shopcat-title {
                font-size: 15px;
                font-weight: 700;
                color: #111827;
                margin: 0 0 18px;
            }

            /* Grid like screenshot */
            .shopcat-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 30px 46px;
                /* row / col */
            }

            @media (max-width: 991.98px) {
                .shopcat-grid {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 24px 30px;
                }
            }

            @media (max-width: 767.98px) {
                .shopcat-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 18px 18px;
                }
            }

            @media (max-width: 420px) {
                .shopcat-grid {
                    grid-template-columns: 1fr;
                }
            }

            .shopcat-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                text-decoration: none;
                color: inherit;
                padding: 8px 6px;
                border-radius: 12px;
                transition: background-color .15s ease, transform .15s ease;
            }

            .shopcat-item:hover {
                background: #f9fafb;
                transform: translateY(-1px);
            }

            .shopcat-icon {
                width: 38px;
                height: 38px;
                flex: 0 0 38px;
                border-radius: 10px;
                display: grid;
                place-items: center;
                background: color-mix(in srgb, var(--sc-color) 12%, transparent);
            }

            .shopcat-icon i {
                font-size: 20px;
                line-height: 1;
                color: var(--sc-color);
            }

            .shopcat-icon-img {
                width: 22px;
                height: 22px;
                object-fit: contain;
                display: block;
            }

            .shopcat-meta {
                display: block;
            }

            .shopcat-name {
                display: block;
                font-size: 16px;
                font-weight: 600;
                color: #111827;
                line-height: 1.25;
            }

            .shopcat-count {
                display: block;
                font-size: 13px;
                color: #6b7280;
                margin-top: 4px;
                line-height: 1.2;
            }
        </style>
    @endpush
@endonce

@php
    /**
     * You can pass data like:
     * <x-frontend.shop-category :items="$items" title="Browse items by category" />
     *
     * Each item:
     * [
     *   'name' => 'Mobiles',
     *   'count' => 72464,
     *   'url' => route('category.show', 'mobiles') or '#',
     *   'color' => '#06b6d4',
     *   'icon' => 'bi-phone' (Bootstrap Icons),
     *   // OR use image icon:
     *   'img' => asset('images/icons/mobile.png')
     * ]
     */

    $title = $title ?? 'Browse items by category';

    // Default demo data (used if you don't pass :items)
$items = $items ?? [
    ['name' => 'Mobiles', 'count' => 72464, 'icon' => 'bi-phone', 'color' => '#06b6d4', 'url' => '#'],
    ['name' => 'Electronics', 'count' => 49088, 'icon' => 'bi-tv', 'color' => '#2563eb', 'url' => '#'],
    ['name' => 'Vehicles', 'count' => 35066, 'icon' => 'bi-car-front', 'color' => '#10b981', 'url' => '#'],
    ['name' => 'Property', 'count' => 15879, 'icon' => 'bi-house-door', 'color' => '#f97316', 'url' => '#'],

    ['name' => 'Home & Living', 'count' => 15287, 'icon' => 'bi-house-gear', 'color' => '#16a34a', 'url' => '#'],
    ['name' => 'Pets & Animals', 'count' => 11463, 'icon' => 'bi-paw', 'color' => '#a855f7', 'url' => '#'],
    [
        'name' => "Men's Fashion & Grooming",
        'count' => 6745,
        'icon' => 'bi-person',
        'color' => '#3b82f6',
        'url' => '#',
    ],
    [
        'name' => 'Hobbies, Sports & Kids',
        'count' => 5862,
        'icon' => 'bi-controller',
        'color' => '#64748b',
        'url' => '#',
    ],

    [
        'name' => "Women's Fashion & Beauty",
        'count' => 4654,
        'icon' => 'bi-person-dress',
        'color' => '#f43f5e',
        'url' => '#',
    ],
    [
        'name' => 'Business & Industry',
        'count' => 3510,
        'icon' => 'bi-buildings',
        'color' => '#0f766e',
        'url' => '#',
    ],
    ['name' => 'Education', 'count' => 2594, 'icon' => 'bi-mortarboard', 'color' => '#1d4ed8', 'url' => '#'],
    ['name' => 'Essentials', 'count' => 2119, 'icon' => 'bi-basket', 'color' => '#84cc16', 'url' => '#'],

    ['name' => 'Jobs', 'count' => 1830, 'icon' => 'bi-briefcase', 'color' => '#0ea5e9', 'url' => '#'],
    ['name' => 'Services', 'count' => 641, 'icon' => 'bi-tools', 'color' => '#6b7280', 'url' => '#'],
    ['name' => 'Agriculture', 'count' => 615, 'icon' => 'bi-flower1', 'color' => '#22c55e', 'url' => '#'],
    ['name' => 'Overseas Jobs', 'count' => 69, 'icon' => 'bi-globe', 'color' => '#2563eb', 'url' => '#'],
    ];
@endphp

<section class="shopcat-wrap">
    <div class="container">
        <div class="shopcat-title">{{ $title }}</div>

        <div class="shopcat-grid" aria-label="Browse items by category">
            @foreach ($items as $it)
                @php
                    $name = $it['name'] ?? 'Category';
                    $count = (int) ($it['count'] ?? 0);
                    $url = $it['url'] ?? '#';
                    $color = $it['color'] ?? '#2563eb';
                    $icon = $it['icon'] ?? 'bi-grid';
                    $img = $it['img'] ?? null;
                @endphp

                <a class="shopcat-item" href="{{ $url }}">
                    <span class="shopcat-icon" style="--sc-color: {{ $color }};">
                        @if (!empty($img))
                            <img src="{{ $img }}" alt="{{ $name }} icon" class="shopcat-icon-img">
                        @else
                            <i class="bi {{ $icon }}"></i>
                        @endif
                    </span>

                    <span class="shopcat-meta">
                        <span class="shopcat-name">{{ $name }}</span>
                        <span class="shopcat-count">{{ number_format($count) }} ads</span>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
