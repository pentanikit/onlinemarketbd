<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Classifieds' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-orange-500 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('classifieds.categories.index') }}" class="text-2xl font-bold">
                Manage your shop
            </a>

            <div class="flex items-center gap-4 text-sm font-medium">
                <a href="{{ route('classifieds.ads.my') }}" class="hover:underline">My Ads</a>
                <a href="{{ route('classifieds.categories.index') }}" class="bg-yellow-400 text-black px-4 py-2 rounded-lg font-semibold">
                    Post a free Ad
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @include('classifieds::partials.flash')
        @yield('content')
    </main>
</body>
</html>