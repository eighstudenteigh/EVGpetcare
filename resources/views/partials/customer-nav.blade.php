<nav class="bg-orange-500 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-2">

        <!-- ✅ Logo and Contact Info -->
        <div>
            <a href="{{ route('customer.dashboard') }}" class="text-3xl font-bold tracking-wide block">
                EVG Juico PetCare
            </a>
            <p class="text-sm mt-1">NDM Juico Building, 1, San Pablo, Castillejos, Zambales</p>
            <p class="text-sm">Contact: (0943) 677-4256</p>
        </div>

        <!-- ✅ Desktop Navigation -->
        <div class="hidden md:flex space-x-6">
            <!-- Dashboard -->
            <a href="{{ route('customer.dashboard') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('customer.dashboard') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                Dashboard
            </a>

            <!-- My Appointments -->
            <a href="{{ route('customer.appointments.index') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('customer.appointments.*') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                My Appointments
            </a>

            <!-- Pets -->
            <a href="{{ route('customer.pets.index') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('customer.pets.*') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                Pets
            </a>

            <!-- Inquiry -->
            <a href="{{ route('customer.inquiry') }}" 
               class="px-4 py-2 rounded-md transition duration-300 
                      {{ request()->routeIs('customer.inquiry') ? 'bg-gray-700 text-white font-bold' : 'bg-orange-600 text-white hover:bg-gray-700' }}">
                Inquiry
            </a>

            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="px-4 py-2 bg-gray-700 text-white rounded-md transition hover:bg-gray-800">
                    Logout
                </button>
            </form>
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
        <a href="{{ route('customer.dashboard') }}" 
           class="block px-6 py-2 text-white text-center transition hover:bg-gray-700">
            Dashboard
        </a>
        <a href="{{ route('customer.appointments.index') }}" 
           class="block px-6 py-2 text-white text-center transition hover:bg-gray-700">
            My Appointments
        </a>
        <a href="{{ route('customer.pets.index') }}" 
           class="block px-6 py-2 text-white text-center transition hover:bg-gray-700">
            Pets
        </a>
        <a href="{{ route('customer.inquiry') }}" 
           class="block px-6 py-2 text-white text-center transition hover:bg-gray-700">
            Inquiry
        </a>
        <div class="border-t border-gray-800"></div>
        <form action="{{ route('logout') }}" method="POST" class="block">
            @csrf
            <button type="submit" 
                    class="w-full text-left px-6 py-2 text-white text-center transition hover:bg-gray-700">
                Logout
            </button>
        </form>
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
