{{-- resources\views\partials\admin-sidebar.blade.php --}}
<aside class="bg-blue-800 text-white w-full h-full p-4 overflow-y-auto">
    <!-- Branding Section -->
    <div class="flex items-center justify-between px-1 py-1">
        <h1 class="text-xl md:text-2xl font-bold">EVG Juico PetCare</h1>
        <button id="closeSidebar" class="md:hidden text-white hover:text-blue-200">
            <i class="ph ph-x w-6 h-6"></i>
        </button>
    </div>
    <hr class="border-t border-blue-500 my-2">
    <nav class="space-y-3 mt-4">

        <!--  Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-600 transition duration-300 
                  {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-gauge w-5 h-5 mr-2"></i>
            Dashboard
        </a>

        <hr class="border-t border-blue-500 my-2">



        <a href="{{ route('admin.appointments') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300 
                  {{ request()->routeIs('admin.appointments') ? 'bg-blue-600 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-calendar-check w-5 h-5 mr-2"></i>
            Requests
        </a>

        <!-- Records -->
        <a href="{{ route('admin.records.index') }}" 
        class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300 
            {{ request()->routeIs('admin.records.*') ? 'bg-blue-600 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-file-text w-5 h-5 mr-2"></i>
        Service Records
        </a>

        <a href="{{ route('admin.inquiries') }}"
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300 
                  {{ request()->routeIs('admin.inquiries') ? 'bg-blue-600 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-chat-circle-text w-5 h-5 mr-2"></i>
            Inquiries
        </a>

        <hr class="border-t border-blue-500 my-2">

        

        <a href="{{ route('admin.services.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300 
                  {{ request()->routeIs('admin.services.index') ? 'bg-blue-600 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-wrench w-5 h-5 mr-2"></i>
            Services
        </a>

        <a href="{{ route('admin.customers.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300 
                  {{ request()->routeIs('admin.customers.index') ? 'bg-blue-600 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-users w-5 h-5 mr-2"></i>
            Customers
        </a>

        <hr class="border-t border-blue-500 my-2">

       

        <a href="{{ route('admins.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300 
                  {{ request()->routeIs('admins.index') ? 'bg-blue-600 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-user-gear w-5 h-5 mr-2"></i>
            Admin Users
        </a>

        <a href="{{ route('admin.pets.index') }}" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300 
                  {{ request()->routeIs('admin.pets.index') ? 'bg-blue-600 shadow-md shadow-blue-900 text-white font-bold' : '' }}">
            <i class="ph ph-paw-print w-5 h-5 mr-2"></i>
            Pets
        </a>

        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-blue-700 transition duration-300">
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