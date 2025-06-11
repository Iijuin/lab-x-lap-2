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
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">
                        <i class="fas fa-user text-blue-500 mr-2"></i>
                        {{ $userResponse->name }}
                    </h2>
                    <p class="text-gray-600">
                        <i class="fas fa-graduation-cap text-green-500 mr-2"></i>
                        {{ $userResponse->program }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500 mb-1">Budget Range</p>
                    <p class="text-lg font-semibold text-gray-800">
                        @php
                            $budgetRanges = [
                                'less-5m' => 'Di bawah 5 Juta',
                                '5m-8m' => '5 Juta - 8 Juta',
                                '8m-12m' => '8 Juta - 12 Juta',
                                '12m-15m' => '12 Juta - 15 Juta',
                                'more-15m' => 'Di atas 15 Juta'
                            ];
                        @endphp
                        {{ $budgetRanges[$userResponse->budget] ?? $userResponse->budget }}
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
                                @if($laptop->image)
                                    <img src="{{ Storage::url($laptop->image) }}" 
                                         alt="{{ $laptop->name }}" 
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
                                <div class="mb-2">
                                    <span class="block text-lg font-bold text-indigo-700">{{ $laptop->name }}</span>
                                </div>
                                <div class="flex items-start justify-between mb-3">
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
                                        <span>{{ $laptop->gpu ?? 'N/A' }}</span>
                                    </div>
                                    @if(isset($laptop->screen_size))
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-tv w-4 mr-2 text-yellow-500"></i>
                                        <span>{{ $laptop->screen_size }}" Display</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Score/Rating -->
                                @if(isset($laptop->swara_score))
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm text-gray-600">Compatibility Score</span>
                                        <span class="text-sm font-semibold">{{ number_format($laptop->swara_score * 100, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-green-400 to-blue-500 h-2 rounded-full" 
                                             style="width: {{ $laptop->swara_score * 100 }}%"></div>
                                    </div>
                                </div>
                                @endif
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

        <!-- Preferences Summary -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">
                <i class="fas fa-clipboard-list text-indigo-600 mr-2"></i>
                Ringkasan Preferensi
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Budget</h3>
                    <p class="text-lg font-semibold text-gray-800">
                        {{ $budgetRanges[$userResponse->budget] ?? $userResponse->budget }}
                    </p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">RAM</h3>
                    <p class="text-lg font-semibold text-gray-800">{{ $userResponse->ram }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Storage</h3>
                    <p class="text-lg font-semibold text-gray-800">{{ $userResponse->storage }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">GPU</h3>
                    <p class="text-lg font-semibold text-gray-800">{{ $userResponse->gpu }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Screen Size</h3>
                    <p class="text-lg font-semibold text-gray-800">{{ $userResponse->screen }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Aktivitas Utama</h3>
                    <p class="text-lg font-semibold text-gray-800">
                        @php
                            $activities = json_decode($userResponse->activities);
                            echo is_array($activities) ? implode(', ', $activities) : $activities;
                        @endphp
                    </p>
                </div>
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