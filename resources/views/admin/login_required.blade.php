<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Login Required</title>
    
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
        <div class="max-w-2xl w-full space-y-8 bg-white rounded-lg p-8 shadow-lg">
            <div>
                <h2 class="title text-center text-[48px] font-light leading-[1] text-[#5a5858] mb-4">
                    ADMIN<br/>PANEL
                </h2>
                <p class="text-center text-xl text-[#6b6b6b]">Panel Administrasi</p>
            </div>
            
            <div class="bg-[#1e40af] text-white px-6 py-4 rounded-lg shadow-lg animate-fade-in" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                    <div>
                        <p class="font-bold mb-1">Peringatan Akses Admin</p>
                        <p>Untuk mengakses panel admin, Anda harus login terlebih dahulu menggunakan akun admin Anda.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-[#1e40af] text-white font-semibold rounded-lg shadow-md hover:bg-[#1e3a8a] focus:outline-none focus:ring-2 focus:ring-[#1e40af] focus:ring-opacity-75 transition-colors duration-200">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login Admin
                </a>
            </div>

            <div class="text-center">
                <a href="{{ route('home') }}" class="text-[#6b6b6b] hover:text-[#1e40af] transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html> 