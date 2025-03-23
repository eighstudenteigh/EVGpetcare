<header class="bg-white text-orange-600 py-4 shadow-md pl-64 sticky top-0 z-50">
    <div class="flex items-center justify-end px-6 gap-4">

        <!-- Settings Icon -->
        <a href="{{ route('admin.settings') }}" 
           class="flex items-center gap-2 text-orange-600 hover:text-orange-500 cursor-pointer">
            <i class="ph ph-gear-bold text-2xl"></i>
        </a>

        <!-- Admin Profile & Logout -->
        <div class="relative">
            <button id="profileDropdown" class="flex items-center gap-2">
                <span>{{ Auth::user()->name }}</span>
                <div class="w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </button>

            <!-- Dropdown Menu -->
            <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-orange-600 text-white shadow-lg rounded-md">
                <a href="#" class="block px-4 py-2 hover:bg-orange-500">Profile</a>
                <a href="{{ route('admin.settings') }}" class="block px-4 py-2 hover:bg-orange-500">Settings</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-orange-500">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    document.getElementById('profileDropdown').addEventListener('click', function () {
        document.getElementById('dropdownMenu').classList.toggle('hidden');
    });
</script>
