<aside class="bg-orange-600 text-white w-full h-full p-4 overflow-y-auto">
    <!-- Branding Section -->
    <div class="flex items-center justify-between px-1 py-1">
        <h1 class="text-xl md:text-2xl font-bold">EVG Juico PetCare</h1>
        <button id="closeSidebar" class="md:hidden text-white hover:text-orange-200">
            <i class="ph ph-x w-6 h-6"></i>
        </button>
    </div>
    <hr class="border-t border-orange-300 my-2">
    <nav class="space-y-3 mt-4">

        <!-- 🟠 Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-gauge w-5 h-5 mr-2"></i>
            Dashboard
        </a>

        <hr class="border-t border-orange-300 my-2">

        <!-- 🔹 Management Section -->
        <p class="text-sm uppercase text-orange-300 font-bold px-4 mt-2">Management</p>

        <a href="{{ route('admin.appointments') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admin.appointments') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-calendar-check w-5 h-5 mr-2"></i>
            Requests
        </a>

        <a href="{{ route('admin.inquiries') }}"
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admin.inquiries') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-chat-circle-text w-5 h-5 mr-2"></i>
            Inquiries
        </a>

        <hr class="border-t border-orange-300 my-2">

        <!-- 🔹 Reports Section -->
        <p class="text-sm uppercase text-orange-300 font-bold px-4 mt-2">Reports</p>

        <a href="{{ route('admin.services.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admin.services.index') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-wrench w-5 h-5 mr-2"></i>
            Services
        </a>

        <a href="{{ route('admin.customers.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admin.customers.index') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-users w-5 h-5 mr-2"></i>
            Customers
        </a>

        <hr class="border-t border-orange-300 my-2">

        <!-- 🔹 Settings Section -->
        <p class="text-sm uppercase text-orange-300 font-bold px-4 mt-2">Settings</p>

        <a href="{{ route('admins.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admins.index') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-user-gear w-5 h-5 mr-2"></i>
            Admin Users
        </a>

        <a href="{{ route('admin.pets.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admin.pets.index') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-paw-print w-5 h-5 mr-2"></i>
            Pets
        </a>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300">
            <i class="ph ph-sign-out w-5 h-5 mr-2"></i>
            Logout
        </a>

        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
            @csrf
        </form>
    </nav>

    <script>
        // Close sidebar when the close button is clicked (mobile only)
        document.getElementById('closeSidebar')?.addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>
</aside>