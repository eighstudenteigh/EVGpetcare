<nav class="bg-orange-500 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-2">

        <!-- ✅ Logo & Contact Info -->
        <div class="flex flex-col">
            <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold tracking-wide">
                EVG Juico PetCare
            </a>
            <p class="text-xs sm:text-sm mt-1">NDM Juico Building, 1, San Pablo, Castillejos, Zambales</p>
            <p class="text-xs sm:text-sm">Contact: (0943) 677-4256</p>
        </div>

        <!-- ✅ Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden focus:outline-none">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>

        <!-- ✅ Desktop Navigation -->
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('customer.appointments.index') }}" class="nav-link {{ request()->routeIs('customer.appointments.*') ? 'active' : '' }}">
                My Appointments
            </a>
            <a href="{{ route('customer.pets.index') }}" class="nav-link {{ request()->routeIs('customer.pets.*') ? 'active' : '' }}">
                Pets
            </a>
            <a href="{{ route('customer.inquiry') }}" class="nav-link {{ request()->routeIs('customer.inquiry') ? 'active' : '' }}">
                Inquiry
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link bg-gray-700 hover:bg-gray-800">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- ✅ Mobile Menu -->
    <div id="mobileMenu" class="mobile-menu">
        <a href="{{ route('customer.dashboard') }}" class="mobile-link">Dashboard</a>
        <a href="{{ route('customer.appointments.index') }}" class="mobile-link">My Appointments</a>
        <a href="{{ route('customer.pets.index') }}" class="mobile-link">Pets</a>
        <a href="{{ route('customer.inquiry') }}" class="mobile-link">Inquiry</a>
        <div class="border-t border-gray-800"></div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="mobile-link">Logout</button>
        </form>
    </div>
</nav>

<!-- ✅ JavaScript for Mobile Menu -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuButton = document.getElementById("mobileMenuButton");
        const mobileMenu = document.getElementById("mobileMenu");

        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle("open");
        });
    });
</script>

<!-- ✅ Styles -->
<style>
    /* Desktop Links */
    .nav-link {
        @apply px-4 py-2 rounded-md transition duration-300 bg-orange-600 text-white hover:bg-gray-700;
    }
    .active {
        @apply bg-gray-700 font-bold;
    }

    /* ✅ Mobile Menu */
    .mobile-menu {
        @apply absolute top-16 left-0 w-full bg-orange-600 transform transition-all duration-300 overflow-hidden max-h-0;
    }
    .mobile-menu.open {
        max-height: 300px; /* Adjust based on content */
    }
    .mobile-link {
        @apply block px-6 py-3 text-center text-white transition hover:bg-gray-700;
    }
</style>
