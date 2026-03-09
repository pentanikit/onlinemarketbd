@extends('classifieds::layouts.app')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-slate-900 mb-2">Browse items by category</h1>
        <p class="text-gray-600">Choose a category and post your ad in a minute.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('classifieds.ads.create', $category->slug) }}"
               class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 hover:shadow-md transition">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-2xl">
                        {{ $category->icon ?: '📦' }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-lg">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">Post your item</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection