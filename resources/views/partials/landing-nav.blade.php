<!-- Main Navigation -->
<nav class="bg-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-3">
        <!-- Logo/Brand -->
        <div class="flex items-center space-x-3">
            
            <a href="{{ route('home') }}" class="text-2xl font-extrabold tracking-tight font-serif italic">
                <span class="text-orange-600">EVG</span> 
                <span class="text-gray-800">Juico PetCare</span>
            </a>
        </div>

        <!-- Desktop Navigation with Icons -->
        <div class="hidden md:flex space-x-1">
            <a href="{{ route('home') }}" 
               class="px-4 py-2 rounded-md transition duration-300 flex items-center space-x-1
                      {{ request()->routeIs('home') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Home</span>
            </a>

            <a href="{{ route('about.us') }}" 
               class="px-4 py-2 rounded-md transition duration-300 flex items-center space-x-1
                      {{ request()->routeIs('about.us') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>About Us</span>
            </a>

            <a href="{{ route('services') }}" 
               class="px-4 py-2 rounded-md transition duration-300 flex items-center space-x-1
                      {{ request()->routeIs('services') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <span>Services</span>
            </a>

            <a href="{{ route('customer.inquiry') }}" 
               class="px-4 py-2 rounded-md transition duration-300 flex items-center space-x-1
                      {{ request()->routeIs('customer.inquiry') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
                <span>Inquiry</span>
            </a>
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu with Icons -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <a href="{{ route('home') }}" 
           class="block px-6 py-3 text-center transition flex items-center justify-center space-x-2
                  {{ request()->routeIs('home') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Home</span>
        </a>
        <a href="{{ route('about.us') }}" 
           class="block px-6 py-3 text-center transition flex items-center justify-center space-x-2
                  {{ request()->routeIs('about.us') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>About Us</span>
        </a>
        <a href="{{ route('services') }}" 
           class="block px-6 py-3 text-center transition flex items-center justify-center space-x-2
                  {{ request()->routeIs('services') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Services</span>
        </a>
        <a href="{{ route('customer.inquiry') }}" 
           class="block px-6 py-3 text-center transition flex items-center justify-center space-x-2
                  {{ request()->routeIs('customer.inquiry') ? 'text-orange-600 font-bold' : 'text-gray-700 hover:text-orange-600' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <span>Inquiry</span>
        </a>
        {{-- <div class="border-t border-gray-200 py-2">
            <a href="{{ route('login') }}" 
               class="block px-6 py-2 text-gray-700 text-center transition hover:text-orange-600 flex items-center justify-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Login</span>
            </a>
            <a href="{{ route('register') }}" 
               class="block px-6 py-2 text-gray-700 text-center transition hover:text-orange-600 flex items-center justify-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span>Sign Up</span>
            </a>
        </div> --}}
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuButton = document.getElementById("mobileMenuButton");
        const mobileMenu = document.getElementById("mobileMenu");

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener("click", function () {
                mobileMenu.classList.toggle("hidden");
            });
        }
    });
</script>