@extends('layouts.user')

@section('title', 'Hasil Rekomendasi Laptop')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">
                <i class="fas fa-trophy text-yellow-500 mr-3"></i>
                Hasil Rekomendasi Laptop
            </h1>
            <p class="text-lg text-gray-600">Berdasarkan preferensi dan kebutuhan Anda</p>
        </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-user text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">{{ $userResponse->name ?? 'Pengguna' }}</h3>
                        <p class="text-gray-600">Email: {{ $userResponse->email ?? 'Tidak tersedia' }}</p>
                        <p class="text-sm text-gray-500">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $userResponse->created_at ? $userResponse->created_at->format('d M Y, H:i') : 'Tidak tersedia' }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Budget Range</p>
                    <p class="text-lg font-semibold text-green-600">
                        {{ ucfirst(str_replace('-', ' ', $userResponse->budget)) }}
                    </p>
                    <p class="text-sm text-gray-500">
                        Rp {{ number_format($userResponse->min_budget ?? 0, 0, ',', '.') }} - 
                        Rp {{ number_format($userResponse->max_budget ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Results Section -->
        @if(isset($recommendations) && count($recommendations) > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-laptop text-indigo-600 mr-2"></i>
                    Rekomendasi Laptop Terbaik
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($recommendations as $index => $laptop)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 {{ $index === 0 ? 'ring-2 ring-yellow-400' : '' }}">
                            @if($index === 0)
                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white text-center py-2">
                                    <i class="fas fa-crown mr-2"></i>
                                    <span class="font-semibold">REKOMENDASI TERBAIK</span>
                                </div>
                            @endif
                            
                            <!-- Laptop Image -->
                            <div class="bg-gray-50 p-6 flex items-center justify-center h-48">
                                @if(isset($laptop->image) && $laptop->image)
                                    <img src="{{ $laptop->image }}" alt="{{ $laptop->brand }} {{ $laptop->model }}" 
                                         class="max-h-full max-w-full object-contain">
                                @else
                                    <div class="text-gray-400 text-center">
                                        <i class="fas fa-laptop text-6xl mb-2"></i>
                                        <p class="text-sm">No Image</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Laptop Info -->
                            <div class="p-6">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ $laptop->brand }} {{ $laptop->model }}
                                    </h3>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">
                                        #{{ $index + 1 }}
                                    </span>
                                </div>
                                
                                <!-- Price -->
                                <div class="mb-4">
                                    <span class="text-2xl font-bold text-green-600">
                                        Rp {{ number_format($laptop->price ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <!-- Specs -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-microchip w-4 mr-2 text-blue-500"></i>
                                        <span>{{ $laptop->processor ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-memory w-4 mr-2 text-green-500"></i>
                                        <span>{{ $laptop->ram ?? 'N/A' }} RAM</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-hdd w-4 mr-2 text-purple-500"></i>
                                        <span>{{ $laptop->storage ?? 'N/A' }} Storage</span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-desktop w-4 mr-2 text-red-500"></i>
                                        <span>{{ $laptop->graphics ?? 'N/A' }}</span>
                                    </div>
                                    @if(isset($laptop->screen_size))
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-tv w-4 mr-2 text-yellow-500"></i>
                                        <span>{{ $laptop->screen_size }}" Display</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Score/Rating -->
                                @if(isset($laptop->score))
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm text-gray-600">Compatibility Score</span>
                                        <span class="text-sm font-semibold">{{ number_format($laptop->score, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-green-400 to-blue-500 h-2 rounded-full" 
                                             style="width: {{ $laptop->score }}%"></div>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Detail
                                    </button>
                                    <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg transition-colors duration-200">
                                        <i class="fas fa-shopping-cart mr-1"></i>
                                        Beli
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- No Results -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-search text-6xl"></i>
                </div>
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Tidak Ada Hasil</h3>
                <p class="text-gray-600 mb-6">Maaf, tidak ada laptop yang sesuai dengan kriteria Anda.</p>
                <a href="{{ route('user.form') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg transition-colors duration-200">
                    <i class="fas fa-redo mr-2"></i>
                    Coba Lagi
                </a>
            </div>
        @endif

        <!-- User Preferences Summary -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">
                <i class="fas fa-list-check text-indigo-600 mr-2"></i>
                Ringkasan Preferensi Anda
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @if(isset($userResponse->program))
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 p-2 rounded-full">
                        <i class="fas fa-graduation-cap text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Program Studi</p>
                        <p class="font-semibold text-gray-800">{{ $userResponse->program }}</p>
                    </div>
                </div>
                @endif
                
                @if(isset($userResponse->activities))
<div class="flex items-center space-x-3">
    <div class="bg-green-100 p-2 rounded-full">
        <i class="fas fa-tasks text-green-600"></i>
    </div>
    <div>
        <p class="text-sm text-gray-500">Aktivitas</p>
        <p class="font-semibold text-gray-800">{{ $userResponse->activities_display }}</p>
    </div>
</div>
@endif
                
                @if(isset($userResponse->budget))
                <div class="flex items-center space-x-3">
                    <div class="bg-purple-100 p-2 rounded-full">
                        <i class="fas fa-wallet text-purple-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Budget</p>
                        <p class="font-semibold text-gray-800">{{ ucfirst(str_replace('-', ' ', $userResponse->budget)) }}</p>
                    </div>
                </div>
                @endif
                
                @if(isset($userResponse->ram))
                <div class="flex items-center space-x-3">
                    <div class="bg-yellow-100 p-2 rounded-full">
                        <i class="fas fa-memory text-yellow-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">RAM Preferred</p>
                        <p class="font-semibold text-gray-800">{{ strtoupper($userResponse->ram) }}</p>
                    </div>
                </div>
                @endif
                
                @if(isset($userResponse->storage))
                <div class="flex items-center space-x-3">
                    <div class="bg-red-100 p-2 rounded-full">
                        <i class="fas fa-hdd text-red-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Storage Preferred</p>
                        <p class="font-semibold text-gray-800">{{ strtoupper(str_replace('-', ' ', $userResponse->storage)) }}</p>
                    </div>
                </div>
                @endif
                
                @if(isset($userResponse->gpu))
                <div class="flex items-center space-x-3">
                    <div class="bg-indigo-100 p-2 rounded-full">
                        <i class="fas fa-tv text-indigo-600"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">GPU Preferred</p>
                        <p class="font-semibold text-gray-800">{{ ucfirst(str_replace('-', ' ', $userResponse->gpu)) }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center space-x-4">
            <a href="{{ route('user.form') }}" 
               class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg transition-colors duration-200">
                <i class="fas fa-search mr-2"></i>
                Cari Lagi
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white py-3 px-6 rounded-lg transition-colors duration-200">
                <i class="fas fa-print mr-2"></i>
                Cetak Hasil
            </button>
            <button onclick="shareResults()" 
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg transition-colors duration-200">
                <i class="fas fa-share-alt mr-2"></i>
                Bagikan
            </button>
        </div>
    </div>
</div>

<!-- Modal for laptop details (optional) -->
<div id="laptopModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div id="modalContent">
                    <!-- Dynamic content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Function to share results
function shareResults() {
    if (navigator.share) {
        navigator.share({
            title: 'Hasil Rekomendasi Laptop',
            text: 'Lihat rekomendasi laptop terbaik untuk saya!',
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link berhasil disalin ke clipboard!');
        });
    }
}

// Function to show laptop details (optional)
function showLaptopDetails(laptopId) {
    // You can implement AJAX call to get detailed laptop info
    document.getElementById('laptopModal').classList.remove('hidden');
}

// Close modal
document.addEventListener('click', function(e) {
    if (e.target.id === 'laptopModal') {
        document.getElementById('laptopModal').classList.add('hidden');
    }
});

// Print styles
const printStyles = `
    <style>
        @media print {
            body { font-size: 12px; }
            .no-print { display: none !important; }
            .bg-gradient-to-br { background: white !important; }
            .shadow-lg { box-shadow: none !important; border: 1px solid #e5e7eb; }
        }
    </style>
`;
document.head.insertAdjacentHTML('beforeend', printStyles);
</script>

<style>
/* Additional custom styles */
.laptop-card:hover {
    transform: translateY(-2px);
}

.spec-icon {
    width: 16px;
    display: inline-block;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }
    
    .grid-cols-3 {
        grid-template-columns: repeat(1, minmax(0, 1fr));
    }
}
</style>
@endsection