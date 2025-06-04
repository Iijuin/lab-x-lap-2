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
    <style>
        body {
            font-family: 'Roboto Mono', monospace;
        }
        .btn-find {
            font-family: 'Roboto Mono', monospace;
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
            <div class="text-[0.875rem] font-normal tracking-widest">
                <a href="#" class="hover:text-gray-600 transition-colors">
                    ABOUT
                </a>
            </div>
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
</body>
</html>