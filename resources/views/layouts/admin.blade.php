<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-100">

    <!-- Admin Header -->
    @include('partials.admin-header')

    <div class="flex">
        <!-- Admin Sidebar (Fixed) -->
        @include('partials.admin-sidebar')

        <!-- Main Content (Properly Adjusted) -->
        <main class="flex-1 p-6 ml-64">
            @yield('content')
        </main>
    </div>

    <!-- Include Footer -->
    @include('partials.admin-footer')
    <script src="{{ asset('js/tooltip.js') }}"></script>
</body>
</html>
