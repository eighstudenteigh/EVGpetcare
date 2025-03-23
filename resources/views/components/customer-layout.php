<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EVG Juico PetCare</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-pantone7541 text-pantone419">
    
    <!-- Include Header -->
    @include('partials.customer-header')

    <!-- Main Content -->
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Include Footer -->
    @include('partials.customer-footer')

</body>
</html>
