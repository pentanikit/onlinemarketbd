@extends('classifieds::layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">My Ads</h1>
        <a href="{{ route('classifieds.categories.index') }}" class="bg-orange-500 text-white px-4 py-2 rounded-xl font-semibold">
            Post Another Ad
        </a>
    </div>

    <div class="space-y-4">
        @forelse($ads as $ad)
            <div class="bg-white rounded-2xl border border-gray-200 p-4 flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-40 h-32 bg-gray-100 rounded-xl overflow-hidden">
                    @if($ad->images->count())
                        <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" class="w-full h-full object-cover" alt="{{ $ad->title }}">
                    @endif
                </div>

                <div class="flex-1">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-semibold">{{ $ad->title }}</h3>
                            <p class="text-sm text-gray-500">{{ $ad->category->name }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-sm bg-gray-100">{{ ucfirst($ad->status) }}</span>
                    </div>

                    <div class="mt-2 text-gray-700">
                        @if($ad->price)
                            ৳{{ number_format($ad->price, 2) }}
                        @else
                            Price on request
                        @endif
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('classifieds.ads.show', $ad->slug) }}" class="text-orange-600 font-medium hover:underline">
                            View Ad
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-200 p-8 text-center text-gray-500">
                No ads found.
            </div>
        @endforelse
    </div>
@endsection