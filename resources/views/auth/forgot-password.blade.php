<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Laptop Decision Support</title>
    
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
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="max-w-md w-full space-y-8 bg-white rounded-lg p-8 shadow-lg">
            <div>
                <h2 class="title text-center text-[48px] font-light leading-[1] text-[#5a5858] mb-4">
                    LUPA<br/>PASSWORD
                </h2>
                <p class="text-center text-xl text-[#6b6b6b]">Masukkan email Anda untuk reset password</p>
            </div>

            <div class="mb-4 text-sm text-gray-600">
                <p class="mb-2">Untuk mereset password admin, silakan masukkan email admin:</p>
                <p class="font-semibold text-indigo-600">admin@example.com</p>
            </div>

            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-[#6b6b6b] hover:text-[#1e40af] transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Login
                </a>
            </div>
        </div>
    </div>
</body>
</html> 