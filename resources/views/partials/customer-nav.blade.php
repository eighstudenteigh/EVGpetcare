<nav class="bg-orange-500 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3">

            <!-- Logo & Contact Info -->
            <div class="flex-shrink-0">
                <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold tracking-wide hover:text-orange-200 transition-all duration-200 hover:pl-1">
                    EVG Juico PetCare
                </a>
                
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobileMenuButton" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-orange-600 hover:p-2.5 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-all duration-200">
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                <a href="{{ route('customer.dashboard') }}" class="nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }} hover:bg-orange-600 hover:px-4 hover:py-2.5">
                    Dashboard
                </a>
                <a href="{{ route('customer.appointments.index') }}" class="nav-link {{ request()->routeIs('customer.appointments.*') ? 'active' : '' }} hover:bg-orange-600 hover:px-4 hover:py-2.5">
                    My Appointments
                </a>
                <a href="{{ route('customer.pets.index') }}" class="nav-link {{ request()->routeIs('customer.pets.*') ? 'active' : '' }} hover:bg-orange-600 hover:px-4 hover:py-2.5">
                    Pets
                </a>
                <a href="{{ route('customer.inquiry') }}" class="nav-link {{ request()->routeIs('customer.inquiry') ? 'active' : '' }} hover:bg-orange-600 hover:px-4 hover:py-2.5">
                    Inquiry
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link logout-btn hover:bg-gray-800 hover:px-4 hover:py-2.5">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden bg-orange-600">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('customer.dashboard') }}" class="mobile-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }} block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-700 hover:text-white hover:px-4 hover:py-3 transition-all duration-200">Dashboard</a>
            <a href="{{ route('customer.appointments.index') }}" class="mobile-link {{ request()->routeIs('customer.appointments.*') ? 'active' : '' }} block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-700 hover:text-white hover:px-4 hover:py-3 transition-all duration-200">My Appointments</a>
            <a href="{{ route('customer.pets.index') }}" class="mobile-link {{ request()->routeIs('customer.pets.*') ? 'active' : '' }} block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-700 hover:text-white hover:px-4 hover:py-3 transition-all duration-200">Pets</a>
            <a href="{{ route('customer.inquiry') }}" class="mobile-link {{ request()->routeIs('customer.inquiry') ? 'active' : '' }} block px-3 py-2 rounded-md text-base font-medium hover:bg-orange-700 hover:text-white hover:px-4 hover:py-3 transition-all duration-200">Inquiry</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mobile-link logout-btn w-full text-left block px-3 py-2 rounded-md text-base font-medium hover:bg-gray-800 hover:px-4 hover:py-3 transition-all duration-200">Logout</button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuButton = document.getElementById("mobileMenuButton");
        const mobileMenu = document.getElementById("mobileMenu");

        mobileMenuButton.addEventListener("click", function () {
            if (mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('block');
            } else {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        });
    });
</script>

<style>
    /* Desktop Links */
    .nav-link {
        @apply px-3 py-2 rounded-md text-sm font-medium transition-all duration-200;
    }
    .nav-link:hover {
        @apply bg-orange-700 text-white;
    }
    .active {
        @apply bg-gray-900 text-white;
    }
    .logout-btn {
        @apply bg-gray-700 text-white hover:bg-gray-800;
    }

    /* Mobile Links */
    .mobile-link {
        @apply text-white hover:bg-orange-700 hover:text-white;
    }
    .mobile-link.active {
        @apply bg-gray-900 text-white;
    }
    .mobile-link.logout-btn {
        @apply bg-gray-700 text-white hover:bg-gray-800;
    }
</style>