<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('EVG Petcare', 'EVG Petcare') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased flex flex-col min-h-screen bg-gray-100">

    <!-- Top Orange Bar -->
    @include('partials.top-blue-nav')
    
    <!-- Navigation Bar -->
    @include('partials.landing-nav')

    <!-- Main Content Wrapper -->
    <main class="flex-grow flex items-center justify-center">
        <div class="w-full max-w-lg p-8 bg-gray-100 rounded-lg">
            {{ $slot }} <!-- Slot to render content from respective views -->
        </div>
    </main>

    <!-- Footer -->
    @include('partials.customer-footer')

    <!-- Tooltip Script -->
    <script src="{{ asset('js/tooltip.js') }}"></script>
</body>
</html>
