<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Config for Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        martian: ['"Martian Mono"', 'monospace'],
                        xanh: ['"Xanh Mono"', 'cursive'],
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Martian+Mono:wght@400;700&family=Xanh+Mono&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-martian">
<div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-gray-800 text-white w-64 hidden lg:block fixed h-screen overflow-y-auto z-40 flex flex-col">
        <div class="p-4">
            <h1 class="text-2xl font-bold font-xanh mb-6">Admin Panel</h1>

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

        <!-- Admin Info & Logout at bottom -->
        <div class="mt-auto p-4 border-t border-gray-700">
            <div class="flex items-center justify-between">
                <span class="text-sm">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-300 hover:text-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Mobile Sidebar -->
    <aside class="fixed inset-y-0 left-0 bg-gray-800 text-white w-64 transform transition-transform duration-200 ease-in-out lg:hidden z-50"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="p-4 flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-xl font-bold font-xanh">Admin Panel</h1>
                <button @click="sidebarOpen = false">
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

            <!-- Admin Info & Logout at bottom for mobile -->
            <div class="mt-auto p-4 border-t border-gray-700">
                <div class="flex items-center justify-between">
                    <span class="text-sm">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-300 hover:text-white">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col lg:ml-64">
        <!-- Topbar -->
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="lg:hidden">
                    <i class="fas fa-bars text-gray-600"></i>
                </button>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto px-6 py-6 bg-gray-100">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
