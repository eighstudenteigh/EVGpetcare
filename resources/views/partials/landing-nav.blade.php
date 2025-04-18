<!-- Main Navigation with Improved Typography -->
<nav class="bg-white shadow-md nav-urban">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-4">
        <!-- Enhanced Logo/Brand with Improved Hover Effect -->
<div class="flex items-center space-x-3">
    <a href="{{ route('home') }}" class="group flex items-end relative overflow-hidden">
        <!-- EVG Text with Enhanced Hover -->
        <span class="text-4xl font-extrabold tracking-tight font-serif italic text-orange-600 
                    group-hover:text-orange-700 group-hover:scale-105 
                    transition duration-300 ease-out transform origin-left">EVG</span>
        
        <!-- Juico PetCare Text with Enhanced Hover -->
        <span class="text-3xl font-bold tracking-tight font-serif italic text-gray-800 ml-2 
                    group-hover:text-gray-900 transition-all duration-300 ease-out">Juico PetCare</span>
        
        <!-- Subtle Underline Animation on Hover -->
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-orange-500 
                    group-hover:w-full transition-all duration-400 ease-out"></span>
    </a>
</div>

        <!-- Desktop Navigation with Improved Typography and Spacing -->
        <div class="hidden md:flex items-center space-x-1">
            <a href="{{ route('about.us') }}" 
               class="px-4 py-2 uppercase tracking-widest text-base font-bold transition duration-300
                      {{ request()->routeIs('about.us') ? 'text-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                Trusted Choice
            </a>
            
            <span class="text-gray-300">/</span>
            
            <a href="{{ route('services') }}" 
               class="px-4 py-2 uppercase tracking-widest text-base font-bold transition duration-300
                      {{ request()->routeIs('services') ? 'text-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                Services
            </a>
            
            <span class="text-gray-300">/</span>
            
            <a href="{{ route('customer.inquiry') }}" 
               class="px-4 py-2 uppercase tracking-widest text-base font-bold transition duration-300
                      {{ request()->routeIs('customer.inquiry') ? 'text-orange-600' : 'text-gray-700 hover:text-orange-600' }}">
                Inquiry
            </a>
        </div>

        <!-- Improved Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden focus:outline-none hover:bg-gray-100 p-2 rounded-md transition duration-200">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu with Improved Typography -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <a href="{{ route('home') }}" 
           class="block px-6 py-3 transition flex items-center space-x-3 font-medium
                  {{ request()->routeIs('home') ? 'text-orange-600 bg-orange-50' : 'text-gray-700 hover:text-orange-600 hover:bg-orange-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Home</span>
        </a>
        <a href="{{ route('about.us') }}" 
           class="block px-6 py-3 transition flex items-center space-x-3 font-medium
                  {{ request()->routeIs('about.us') ? 'text-orange-600 bg-orange-50' : 'text-gray-700 hover:text-orange-600 hover:bg-orange-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span>Trusted Choice</span>
        </a>
        <a href="{{ route('services') }}" 
           class="block px-6 py-3 transition flex items-center space-x-3 font-medium
                  {{ request()->routeIs('services') ? 'text-orange-600 bg-orange-50' : 'text-gray-700 hover:text-orange-600 hover:bg-orange-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            <span>Services</span>
        </a>
        <a href="{{ route('customer.inquiry') }}" 
           class="block px-6 py-3 transition flex items-center space-x-3 font-medium
                  {{ request()->routeIs('customer.inquiry') ? 'text-orange-600 bg-orange-50' : 'text-gray-700 hover:text-orange-600 hover:bg-orange-50' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <span>Inquiry</span>
        </a>
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