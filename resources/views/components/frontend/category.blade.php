<section class="category-strip">
    <div class="container">
        <div class="row g-2">
            @forelse ($categories as $item)
                <div class="col-6 col-sm-4 col-md-2 col-lg-1-5 mb-2">
                    <a style="text-decoration: none;" href="{{ route('frontend.category.show', $item->slug) }}">
                        <div class="category-card">
                            <div class="category-icon-wrapper">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="" width="60"
                                    height="60" srcset="">
                            </div>
                            <div class="category-label">{{ $item->name }}</div>
                        </div>
                    </a>

                </div>
            @empty
                <p>No Categories Found</p>
            @endforelse



        </div>
    </div>
</section>




