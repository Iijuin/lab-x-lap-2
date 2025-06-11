<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Laptop Decision Support</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@400;700&family=Special+Elite&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto Mono', monospace;
            background-color: #f3f1f0;
        }
        .title {
            font-family: 'Special Elite', cursive;
        }
        .input-field {
            background-color: #f3f1f0;
            border: 1px solid #6b6b6b;
            color: #6b6b6b;
            font-size: 1rem;
            padding: 0.75rem 1rem;
            width: 100%;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .input-field:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.2);
        }
        .btn-primary {
            background-color: #1e40af;
            color: white;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #1e3a8a;
        }
        .btn-primary:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.2);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full space-y-8 bg-white rounded-lg p-8 shadow-lg">
            <div>
                <h2 class="title text-center text-[48px] font-light leading-[1] text-[#5a5858] mb-4">
                    LOGIN<br/>ADMIN
                </h2>
                <p class="text-center text-xl text-[#6b6b6b]">Masuk ke panel admin</p>
            </div>
            
            @if (session('admin_access_attempt') && session('warning'))
                <div class="bg-[#1e40af] text-white px-6 py-4 rounded-lg shadow-lg animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                        <div>
                            <p class="font-bold mb-1">Peringatan Akses Admin</p>
                            <p>{{ session('warning') }}</p>
                        </div>
                    </div>
                </div>
            @elseif (session('warning'))
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg" role="alert">
                    <span class="block sm:inline">{{ session('warning') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-[#6b6b6b] mb-2">Email</label>
                        <input id="email" name="email" type="email" required 
                               class="input-field" 
                               placeholder="Masukkan email admin"
                               value="{{ old('email') }}">
                    </div>
                    <div>
                        <label for="password" class="block text-[#6b6b6b] mb-2">Password</label>
                        <input id="password" name="password" type="password" required 
                               class="input-field" 
                               placeholder="Masukkan password">
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn-primary w-full flex justify-center items-center">
                        <span class="mr-2">Login</span>
                        <i class="fas fa-sign-in-alt"></i>
                    </button>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-[#6b6b6b] hover:text-[#1e40af] transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html> 