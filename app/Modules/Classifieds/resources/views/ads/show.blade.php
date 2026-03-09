@extends('classifieds::layouts.app')

@section('content')
    <div class="grid lg:grid-cols-2 gap-8">
        <div>
            @if($ad->images->count())
                <img src="{{ asset('storage/' . $ad->images->first()->image_path) }}" class="w-full h-[420px] object-cover rounded-2xl border border-gray-200" alt="{{ $ad->title }}">
                <div class="grid grid-cols-4 gap-3 mt-4">
                    @foreach($ad->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-24 object-cover rounded-xl border border-gray-200" alt="">
                    @endforeach
                </div>
            @else
                <div class="w-full h-[420px] bg-gray-200 rounded-2xl flex items-center justify-center text-gray-500">
                    No image uploaded
                </div>
            @endif
        </div>

        <div>
            <div class="mb-3">
                <span class="inline-block bg-orange-100 text-orange-700 text-sm px-3 py-1 rounded-full">
                    {{ $ad->category->name }}
                </span>
            </div>

            <h1 class="text-3xl font-bold mb-3">{{ $ad->title }}</h1>

            <div class="text-2xl font-bold text-slate-900 mb-4">
                @if($ad->price)
                    ৳{{ number_format($ad->price, 2) }}
                @else
                    Price on request
                @endif
            </div>

            <div class="space-y-2 text-gray-700 mb-6">
                <p><strong>Condition:</strong> {{ $ad->condition_type ?: 'N/A' }}</p>
                <p><strong>Location:</strong> {{ $ad->location ?: 'N/A' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($ad->status) }}</p>
                <p><strong>Views:</strong> {{ $ad->views_count }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-5 mb-6">
                <h3 class="text-lg font-semibold mb-2">Seller Info</h3>
                <p><strong>Name:</strong> {{ $ad->contact_name }}</p>
                <p><strong>Phone:</strong> {{ $ad->contact_phone }}</p>
                <p><strong>Email:</strong> {{ $ad->contact_email ?: 'Not provided' }}</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-200 p-5">
                <h3 class="text-lg font-semibold mb-2">Description</h3>
                <div class="text-gray-700 whitespace-pre-line">
                    {{ $ad->description ?: 'No description added.' }}
                </div>
            </div>
        </div>
    </div>
@endsection