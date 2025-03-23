<header class="bg-gray-800 text-white p-4 flex justify-between items-center">
    <h1 class="text-lg font-semibold">EVG Juico PetCare</h1>
    <div>
        <nav>
            <ul>
        @auth
            @if(Auth::user()->role === 'admin')
                <li><a href="{{ route('admin.dashboard') }}">Admin Dashboard</a></li>
                <li><a href="{{ route('admin.appointments') }}">Manage Appointments</a></li>
                <li><a href="{{ route('admin.services.index') }}">Manage Services</a></li>
            @endif
            Logged in as: Admin  
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="ml-4 text-red-500 hover:underline">Logout</button>
            </form>
        @endauth
            </ul>
        </nav>
    </div>
</header>
