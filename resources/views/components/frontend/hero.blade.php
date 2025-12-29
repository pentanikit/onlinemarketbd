    @php
        $content = \App\Models\SiteContent::where('key', 'home')->first();

    @endphp
    <section class="py-0">
        <div class="container">
            <div class="hero-card">
                <div class="row align-items-center g-2">
                    <img class="mx-auto" src="{{ asset('storage').'/'.$content->hero_image }}" alt=""
                        srcset="">
                </div>
            </div>
        </div>
    </section>