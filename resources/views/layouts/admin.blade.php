<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/@phosphor-icons/web"></script>
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            min-height: calc(100vh - 64px);
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 40;
        }
        /* For mobile sidebar toggle */
        .sidebar-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease;
        }
        .footer {
            margin-top: auto;
        }
        
        /* Mobile sidebar positioning */
        @media (max-width: 768px) {
            main {
                margin-left: 0;
            }
            .footer {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class=" flex flex-col min-h-screen">
    
    <!-- Mobile Menu Toggle Button -->
    <button id="sidebarToggle" class="md:hidden fixed top-4 left-4 z-50 hover:bg-blue-700 transition duration-300  bg-blue-600 text-white p-2 rounded-md shadow-md">
        <i class="ph ph-list text-xl"></i>
    </button>

    <!-- Sidebar Overlay (Mobile Only) -->
    <div id="sidebarOverlay" class="md:hidden fixed inset-0 z-30 bg-black bg-opacity-50 hidden"></div>

    <!-- Admin Header -->
    <header class="text-blue-900 py-4 shadow-md pl-4 md:pl-64">
        <div class="flex items-center justify-end px-6 gap-4">
            <!-- Admin Profile & Logout -->
            <div class="relative">
                <button id="profileDropdown" class="flex items-center gap-2">
                    <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                    <div class="w-8 h-8 bg-blue-700 text-white rounded-full flex items-center justify-center font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </button>

                <!-- Dropdown Menu -->
                <div id="dropdownMenu" class="hidden absolute right-0 mt-2 w-40 bg-blue-700 text-white shadow-lg rounded-md z-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 hover:bg-blue-600">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Admin Sidebar -->
    <aside id="sidebar" class="sidebar text-gray-800 w-64 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        @include('partials.admin-sidebar')
    </aside>

    <!-- Main Layout Wrapper -->
    <div class="flex flex-1">
        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 w-full md:ml-64 transition-all duration-300">
            @yield('content')
        </main>
    </div>

   

    <script src="{{ asset('js/tooltip.js') }}"></script>
    <script>
        // Mobile sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const profileDropdown = document.getElementById('profileDropdown');
            const dropdownMenu = document.getElementById('dropdownMenu');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            });
            
            overlay.addEventListener('click', function() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            });
            
            // Profile dropdown toggle
            profileDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('hidden');
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!profileDropdown.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // Handle window resize to hide mobile sidebar when switching to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    overlay.classList.add('hidden');
                    if (!sidebar.classList.contains('-translate-x-full')) {
                        sidebar.classList.add('-translate-x-full');
                    }
                }
            });
        });
    </script>
</body>
</html>