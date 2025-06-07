<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 bg-gray-800 text-white w-64 transform transition-transform duration-200 ease-in-out"
               :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
            <div class="p-4">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold">Admin Panel</h1>
                    <button @click="sidebarOpen = false" class="lg:hidden">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-home w-6"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a href="{{ route('admin.laptops.index') }}" 
                       class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.laptops.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-laptop w-6"></i>
                        <span>Manajemen Laptop</span>
                    </a>
                    
                    <a href="{{ route('admin.criteria.index') }}" 
                       class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.criteria.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-list-check w-6"></i>
                        <span>Kriteria</span>
                    </a>
                    
                    <a href="{{ route('admin.responses.index') }}" 
                       class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-700 {{ request()->routeIs('admin.responses.*') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-clipboard-list w-6"></i>
                        <span>Hasil Rekomendasi</span>
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="lg:ml-64">
            <!-- Top Navigation -->
            <nav class="bg-white shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <button @click="sidebarOpen = true" class="lg:hidden">
                                <i class="fas fa-bars text-gray-500"></i>
                            </button>
                        </div>
                        
                        <div class="flex items-center">
                            <div class="ml-3 relative">
                                <div class="flex items-center space-x-4">
                                    <span class="text-gray-700">{{ Auth::user()->name }}</span>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="text-gray-600 hover:text-gray-800">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <main class="py-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('aside');
            const sidebarToggle = document.querySelector('button[aria-label="Toggle Sidebar"]');
            
            if (window.innerWidth < 1024 && 
                !sidebar.contains(event.target) && 
                !sidebarToggle.contains(event.target)) {
                sidebarOpen = false;
            }
        });
    </script>
</body>
</html> 