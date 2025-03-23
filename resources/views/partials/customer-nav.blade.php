<!-- resources/views/partials/customer-nav.blade.php -->
<nav class="bg-orange-500 text-white relative">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-4">
        
        <!-- ✅ Logo -->
        <a href="{{ route('customer.dashboard') }}" class="text-xl font-bold tracking-wide">
            EVG Juico PetCare
        </a>

        <!-- ✅ Desktop Navigation -->
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('customer.dashboard') }}" class="hover:text-orange-200">Dashboard</a>
            <a href="{{ route('customer.appointments.index') }}" class="hover:text-orange-200">Appointments</a>
            <a href="{{ route('customer.pets.index') }}" class="hover:text-orange-200">My Pets</a>
        </div>

        <!-- ✅ User Dropdown (Desktop) -->
        <div class="relative hidden md:flex items-center space-x-4">
            <button id="userDropdownButton" class="flex items-center space-x-2 focus:outline-none">
                <span class="text-sm">{{ Auth::user()->name }}</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- ✅ Dropdown Menu -->
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-white text-gray-800 shadow-lg rounded-md">
                <a href="#" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-gray-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- ✅ Mobile Menu Button -->
        <button id="mobileMenuButton" class="md:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" 
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <!-- ✅ Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-orange-600">
        <a href="{{ route('customer.dashboard') }}" class="block px-6 py-2 hover:bg-orange-700">Dashboard</a>
        <a href="{{ route('customer.appointments.index') }}" class="block px-6 py-2 hover:bg-orange-700">Appointments</a>
        <a href="{{ route('customer.pets.index') }}" class="block px-6 py-2 hover:bg-orange-700">My Pets</a>
        <div class="border-t border-orange-400"></div>
        <a href="#" class="block px-6 py-2 hover:bg-orange-700">Profile</a>
        <form method="POST" action="{{ route('logout') }}" class="block">
            @csrf
            <button type="submit" class="w-full text-left px-6 py-2 bg-white text-orange-500 hover:bg-gray-200">
                Logout
            </button>
        </form>
    </div>
</nav>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuButton = document.getElementById("mobileMenuButton");
        const mobileMenu = document.getElementById("mobileMenu");
        const userDropdownButton = document.getElementById("userDropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");
    
        // ✅ Toggle Mobile Menu
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener("click", function () {
                mobileMenu.classList.toggle("hidden");
            });
        }
    
        // ✅ Toggle User Dropdown Menu
        if (userDropdownButton && dropdownMenu) {
            userDropdownButton.addEventListener("click", function () {
                dropdownMenu.classList.toggle("hidden");
            });
    
            // Close dropdown if clicking outside
            document.addEventListener("click", function (event) {
                if (!userDropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add("hidden");
                }
            });
        }
    });
    </script>