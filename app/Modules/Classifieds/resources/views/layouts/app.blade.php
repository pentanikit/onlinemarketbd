<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Classifieds' }}</title>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-orange-500 text-white shadow">
        <x-frontend.header />
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8">
        @include('classifieds::partials.flash')
        @yield('content')
    </main>
</body>
</html>