<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'EVG JUICO PetCare' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <!-- GSAP Libraries -->
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js"></script>
    <script defer src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Open+Sans:wght@400;500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="min-h-screen flex flex-col bg-gray-50 text-gray-800">
    <!-- Top Orange Bar -->
    @include('partials.top-blue-nav')
    
    <!-- Main White Navigation -->
    @include('partials.landing-nav')

    <main class="flex-grow flex flex-col relative overflow-hidden">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.customer-footer')

    @yield('scripts')
</body>
<style>
    .nav-urban {
        font-family: 'Montserrat', sans-serif;
    }
</style>
</html>