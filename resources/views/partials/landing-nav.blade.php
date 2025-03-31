<nav class="bg-orange-500 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-2">

        <!-- ✅ Logo and Contact Info -->
        <div>
            <a href="{{ route('home') }}" class="text-3xl font-bold tracking-wide block">
                EVG Juico PetCare
            </a>
            <p class="text-sm mt-1">NDM Juico Building, 1, San Pablo, Castillejos, Zambales</p>
            <p class="text-sm">Contact: (0943) 677-4256</p>
        </div>

        <!-- ✅ Desktop Navigation -->
        <div class="hidden md:flex space-x-6">
            <!-- Home -->
            <a href="{{ route('home') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('home') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                Home
            </a>

            <!-- The EVG Way (About Us) -->
            <a href="{{ route('about.us') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('about.us') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                The EVG Way
            </a>

            <!-- Services -->
            <a href="{{ route('services') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('services') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                Services
            </a>

            <!-- Inquiry -->
            <a href="{{ route('customer.inquiry') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('customer.inquiry') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                Inquiry
            </a>
        </div>

        <!-- ✅ Authentication Buttons -->
        <div class="hidden md:flex space-x-4">
            <a href="{{ route('login') }}" 
               class="px-4 py-2 bg-orange-600 text-white border border-white rounded-md transition hover:bg-gray-700">
                Login
            </a>
            <a href="{{ route('register') }}" 
               class="px-4 py-2 bg-white text-orange-600 border border-orange-600 rounded-md transition hover:bg-gray-700 hover:text-white">
                Sign Up
            </a>
        </div>

        <!-- ✅ Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- ✅ Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-orange-600">
        <a href="{{ route('home') }}" 
           class="block px-6 py-2 rounded-md text-center transition
                  {{ request()->routeIs('home') ? 'bg-gray-700 text-white font-bold' : 'text-white hover:bg-gray-700' }}">
            Home
        </a>
        <a href="{{ route('about.us') }}" 
           class="block px-6 py-2 rounded-md text-center transition
                  {{ request()->routeIs('about.us') ? 'bg-gray-700 text-white font-bold' : 'text-white hover:bg-gray-700' }}">
            The EVG Way
        </a>
        <a href="{{ route('services') }}" 
           class="block px-6 py-2 rounded-md text-center transition
                  {{ request()->routeIs('services') ? 'bg-gray-700 text-white font-bold' : 'text-white hover:bg-gray-700' }}">
            Services
        </a>
        <a href="{{ route('customer.inquiry') }}" 
           class="block px-6 py-2 rounded-md text-center transition
                  {{ request()->routeIs('customer.inquiry') ? 'bg-gray-700 text-white font-bold' : 'text-white hover:bg-gray-700' }}">
            Inquiry
        </a>
        <div class="border-t border-gray-800"></div>
        <a href="{{ route('login') }}" 
           class="block px-6 py-2 text-white text-center transition hover:bg-gray-700">
            Login
        </a>
        <a href="{{ route('register') }}" 
           class="block px-6 py-2 text-white text-center transition hover:bg-gray-700">
            Sign Up
        </a>
    </div>
</nav>

<!-- ✅ JavaScript for Mobile Menu -->
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
