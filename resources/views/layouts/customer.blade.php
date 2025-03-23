<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVG Juico PetCare</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-warmGray text-pantone419">
    
    <!-- Include Header -->
    @include('partials.customer-nav')

    <!-- Main Content -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Include Footer -->
    @include('partials.customer-footer')
    <script src="{{ asset('js/tooltip.js') }}"></script>

</body>
</html>
