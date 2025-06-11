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

<footer class="relative bg-[#1e1e1e] text-white w-full px-6 pt-6 pb-4">

        <!-- SECTION A: TOP-LEFT CORNER -->
        <div class="absolute top-6 left-6 flex flex-col items-start gap-2 z-50 ml-10 mt-2">
            <a href="/admin" class="border border-white rounded-full px-3 py-1 text-xs hover:bg-white hover:text-black transition">
                Masuk sebagai Admin 
            </a>
            <p class="text-xs leading-snug mt-14 ml-20">
                <span class="text-xs">Situs survey berbasis SWARA</span>
            </p>
            
        </div>

        <!-- SECTION B: BOTTOM-RIGHT CORNER -->
        <div class="absolute top-6 right-6 flex flex-col items-end gap-2 text-right text-sm z-50 mr-10 mt-2">
            <button onclick="window.scrollTo({ top: 0, behavior: 'smooth' });"
                class="border border-white rounded-full px-3 py-1 text-xs hover:bg-white hover:text-black transition">
            ↑ Kembali ke atas
            </button>
            <div class="space-y-1 mt-14 mr-14">
                <div><span class="text-gray-400 text-xs">Naesya Qonitha</span><span class="ml-14 text-xs">UI/UX Designer</span></div>
                <div><span class="text-gray-400 text-xs">Muhtria Harlika</span><span class="ml-24 text-xs">Developer</span></div>
                <div><span class="text-gray-400 text-xs">Gerraldy Ghassan Herfio</span><span class="ml-24 text-xs">Developer</span></div>
            </div>
        
        </div>



        <!-- Main Content: LAB X LAP -->
        <div class="text-center mt-52 mb-6">
            <h1 class="text-[14vw] leading-none font-medium tracking-tight">LAB X LAP</h1>

            <!-- Bottom-left caption -->
            <p class="absolute left-6 bottom-4 text-xs font-mono leading-tight ml-28">
            Temukan laptop terbaikmu
            </p>

            <!-- Bottom-right copyright -->
            <p class="absolute right-6 bottom-4 text-xs text-gray-400 mr-20">
            Copyright © 2025. All rights reserved.
            </p>
        </div>
    </footer>
    
</body>
</html>
