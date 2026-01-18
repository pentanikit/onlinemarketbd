@php
        $title = $title ?? 'Browse items by category';
@endphp

<section class="shopcat-wrap">
    <div class="container">
        <div class="shopcat-title">{{ $title }}</div>

        <div class="shopcat-grid" aria-label="Browse items by category">
            @foreach ($sellercategories as $it)


                <a class="shopcat-item" href="{{ $it->slug }}">
                    <span class="shopcat-icon" >

                         {{ $icon }}

                    </span>

                    <span class="shopcat-meta">
                        <span class="shopcat-name">{{ $it->name }}</span>
                        {{-- <span class="shopcat-count">{{ number_format($count) }} ads</span> --}}
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>