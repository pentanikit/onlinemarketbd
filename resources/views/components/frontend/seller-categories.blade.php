@php
        $title = $title ?? 'Browse items by category';
@endphp
<style>
    .shopcat-wrap {
    padding: 40px 0 20px;
    background: #ffffff;
}

.shopcat-title {
    font-size: 28px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 28px;
    line-height: 1.3;
}

.shopcat-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 34px 38px;
    align-items: start;
}

.shopcat-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    text-decoration: none;
    background: transparent;
    padding: 4px 0;
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.shopcat-item:hover {
    transform: translateY(-2px);
    opacity: 0.95;
}

.shopcat-icon {
    width: 38px;
    min-width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
    margin-top: 2px;
}

.shopcat-icon svg,
.shopcat-icon img,
.shopcat-icon i {
    width: 34px;
    height: 34px;
    display: block;
}

.shopcat-meta {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.shopcat-name {
    font-size: 17px;
    font-weight: 500;
    color: #1f2937;
    line-height: 1.45;
    margin-bottom: 3px;
    word-break: break-word;
}

.shopcat-count {
    font-size: 14px;
    font-weight: 400;
    color: #6b7280;
    line-height: 1.4;
}

@media (max-width: 1199px) {
    .shopcat-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 28px 26px;
    }
}

@media (max-width: 991px) {
    .shopcat-wrap {
        padding: 32px 0 16px;
    }

    .shopcat-title {
        font-size: 24px;
        margin-bottom: 24px;
    }

    .shopcat-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 24px 20px;
    }

    .shopcat-name {
        font-size: 16px;
    }

    .shopcat-count {
        font-size: 13px;
    }
}

@media (max-width: 575px) {
    .shopcat-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .shopcat-item {
        gap: 12px;
    }

    .shopcat-icon {
        width: 34px;
        min-width: 34px;
        height: 34px;
    }

    .shopcat-icon svg,
    .shopcat-icon img,
    .shopcat-icon i {
        width: 30px;
        height: 30px;
    }

    .shopcat-name {
        font-size: 15px;
    }

    .shopcat-count {
        font-size: 13px;
    }
}
</style>
<section class="shopcat-wrap">
    <div class="container">
        <div class="shopcat-title">{{ $title }}</div>

        <div class="shopcat-grid" aria-label="Browse items by category">
            @foreach ($sellercategories as $it)
                <a class="shopcat-item" href="{{ route('sellercategoryproducts', $it->slug) }}">
                    <span class="shopcat-icon">
                        {!! $it->icon !!}
                    </span>

                    <span class="shopcat-meta">
                        <span class="shopcat-name">{{ $it->name }}</span>

                        {{-- @if(isset($it->products_count))
                            <span class="shopcat-count">{{ number_format($it->products_count) }} টি বিজ্ঞাপন</span>
                        @elseif(isset($it->items_count))
                            <span class="shopcat-count">{{ number_format($it->items_count) }} টি বিজ্ঞাপন</span>
                        @elseif(isset($it->ads_count))
                            <span class="shopcat-count">{{ number_format($it->ads_count) }} টি বিজ্ঞাপন</span>
                        @endif --}}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>