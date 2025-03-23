<header class="bg-primary text-white p-4 flex justify-between items-center">
    <!-- Logo -->
    <div class="flex items-center">
        
        <h1 class="text-2xl font-bold ml-2">EVG Juico PetCare</h1>
    </div>

    <!-- User Dropdown -->
    <div class="relative">
        <button id="userMenuButton" class="flex items-center space-x-2">
            <span>{{ Auth::user()->name }}</span>
            <div class="bg-gray-800 text-white rounded-full h-8 w-8 flex items-center justify-center">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        </button>

        <!-- Dropdown Menu -->
        <div id="userMenu" class="hidden absolute right-0 bg-white text-black rounded-md shadow-md mt-2 w-40">
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
            </form>
        </div>
    </div>
</header>


<script>
    document.getElementById('userMenuButton').addEventListener('click', function() {
        document.getElementById('userMenu').classList.toggle('hidden');
    });
</script>
