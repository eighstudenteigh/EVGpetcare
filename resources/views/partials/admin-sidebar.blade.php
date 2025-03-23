<aside class="bg-orange-600 text-white w-64 min-h-screen p-4 fixed top-0 left-0 z-50">
    
    <!-- Branding Section -->
    <div class="flex items-center px-1 py-1">
        <h1 class="text-2xl font-bold">EVG Juico PetCare</h1>
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

        <a href="#" 
           class="flex items-center px-4 py-3 rounded-md hover:bg-orange-400 transition duration-300 
                  {{ request()->routeIs('admin.settings') ? 'bg-orange-500 shadow-md shadow-orange-900 text-white font-bold' : '' }}">
            <i class="ph ph-gear w-5 h-5 mr-2"></i>
            Settings
        </a>
    </nav>
</aside>
