<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>@yield('title', 'Lab x Lap')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet"/>
    <!-- In your <head> section -->
    <link href="https://fonts.googleapis.com/css2?family=Martian+Mono:wght@400;700&family=Xanh+Mono&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Martian Mono', monospace;
        }
        .btn-find {
            font-family: 'Martian Mono', monospace;
            font-size: 0.625rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            background: linear-gradient(to bottom, #d9d9d9, #7a7a7a);
            border-radius: 9999px;
            padding: 0.125rem 1.5rem;
            color: #f0f0f0;
            text-shadow: 0 1px 1px #00000080;
            box-shadow:
                inset 0 1px 0 #ffffff80,
                inset 0 -1px 3px #00000080;
            border: 1px solid #a0a0a0;
            transition: background 0.3s ease;
        }
        .btn-find:hover {
            background: linear-gradient(to bottom, #7a7a7a, #d9d9d9);
            color: #e0e0e0;
        }
        @yield('styles')
    </style>
</head>
<body class="bg-[#f2f0ef] min-h-screen flex flex-col">
    <header class="flex justify-between items-center px-8 py-6">
        <div class="text-[1.25rem] font-normal tracking-widest">
            <a href="{{ route('home') }}" class="hover:text-gray-600 transition-colors">
                LAB X LAP
            </a>
        </div>
        <div class="flex space-x-6">
            <button class="btn-find select-none" onclick="handleFindLaptop()">
                FIND YOUR BEST LAPTOP
            </button>
            
        </div>
    </header>



    <main class="flex-grow @yield('main-classes', 'flex justify-center items-center relative px-6')">
        @yield('content')
    </main>

    @yield('scripts')
    <script>
        function handleFindLaptop() {
            // Redirect to questions page to start laptop finder
            window.location.href = "{{ route('questions.index') }}";
        }
    </script>

    

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