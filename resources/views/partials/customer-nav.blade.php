<nav class="bg-blue-800 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-3">

            <!-- Logo & Contact Info -->
            <div class="flex-shrink-0">
                <a href="{{ route('customer.dashboard') }}" class="text-2xl font-bold tracking-wide transition-all duration-300 group">
                    <span class="group-hover:text-blue-200">EVG Juico PetCare</span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button id="mobileMenuButton" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-blue-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white transition-all duration-300">
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex md:items-center md:space-x-6">
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
                    <button type="submit" class="logout-btn">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="md:hidden hidden bg-blue-700">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="{{ route('customer.dashboard') }}" class="mobile-link {{ request()->routeIs('customer.dashboard') ? 'active-mobile' : '' }}">Dashboard</a>
            <a href="{{ route('customer.appointments.index') }}" class="mobile-link {{ request()->routeIs('customer.appointments.*') ? 'active-mobile' : '' }}">My Appointments</a>
            <a href="{{ route('customer.pets.index') }}" class="mobile-link {{ request()->routeIs('customer.pets.*') ? 'active-mobile' : '' }}">Pets</a>
            <a href="{{ route('customer.inquiry') }}" class="mobile-link {{ request()->routeIs('customer.inquiry') ? 'active-mobile' : '' }}">Inquiry</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="mobile-link logout-mobile w-full text-left">Logout</button>
            </form>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const mobileMenuButton = document.getElementById("mobileMenuButton");
        const mobileMenu = document.getElementById("mobileMenu");

        mobileMenuButton.addEventListener("click", function () {
            mobileMenu.classList.toggle('hidden');
            
            // Smooth animation for mobile menu
            if (!mobileMenu.classList.contains('hidden')) {
                mobileMenu.style.maxHeight = "0";
                mobileMenu.style.opacity = "0";
                setTimeout(() => {
                    mobileMenu.style.maxHeight = mobileMenu.scrollHeight + "px";
                    mobileMenu.style.opacity = "1";
                }, 10);
            } else {
                mobileMenu.style.maxHeight = "0";
                mobileMenu.style.opacity = "0";
                setTimeout(() => {
                    mobileMenu.style.display = "none";
                }, 300);
            }
        });
    });
</script>

<style>
    /* Desktop Navigation Links with Underline Effect */
    .nav-link {
        position: relative;
        padding: 0.5rem 0.75rem;
        font-weight: 500;
        font-size: 0.95rem;
        transition: color 0.3s ease;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: white;
        transform: translateX(-50%);
        transition: width 0.3s ease;
    }

    .nav-link:hover {
        color: #bfdbfe; /* text-blue-200 */
    }

    .nav-link:hover::after {
        width: 80%;
    }

    /* Active state */
    .nav-link.active::after {
        width: 80%;
        background-color: #bfdbfe; /* text-blue-200 */
    }

    .nav-link.active {
        color: white;
        background-color: rgba(30, 64, 175, 0.6); /* Transparent blue-900 */
        border-radius: 0.375rem;
    }

    /* Logout button */
    .logout-btn {
        padding: 0.5rem 1rem;
        font-weight: 500;
        font-size: 0.95rem;
        color: white;
        background-color: rgba(29, 78, 216, 0.7); /* Transparent blue-700 */
        border-radius: 0.375rem;
        transition: all 0.3s ease;
    }

    .logout-btn:hover {
        background-color: rgba(30, 58, 138, 0.8); /* Transparent blue-900 */
        transform: translateY(-1px);
    }

    /* Mobile Navigation */
    #mobileMenu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, opacity 0.3s ease;
    }

    .mobile-link {
        display: block;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        color: white;
        border-radius: 0.375rem;
        transition: background-color 0.3s ease, color 0.3s ease, transform 0.2s ease;
        margin-bottom: 0.25rem;
    }

    .mobile-link:hover {
        background-color: rgba(37, 99, 235, 0.6); /* Transparent blue-600 */
        transform: translateX(4px);
    }

    .active-mobile {
        background-color: rgba(30, 58, 138, 0.8); /* Transparent blue-900 */
        position: relative;
    }

    .active-mobile::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background-color: white;
        border-radius: 0 2px 2px 0;
    }

    .logout-mobile {
        background-color: rgba(29, 78, 216, 0.5); /* Transparent blue-700 */
    }

    .logout-mobile:hover {
        background-color: rgba(30, 58, 138, 0.7); /* Transparent blue-900 */
    }
</style>