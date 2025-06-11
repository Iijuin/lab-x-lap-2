@extends('layouts.user')

@section('title', 'Hasil Rekomendasi Laptop')

@section('content')
<div class="min-h-screen bg-[#f3f1f0] py-8">
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-[48px] font-light leading-[1] text-[#5a5858] mb-4">
                HASIL<br/>REKOMENDASI
            </h1>
            <p class="text-xl text-[#6b6b6b]">Berdasarkan preferensi dan kebutuhan Anda</p>
        </div>

        <!-- User Info Card -->
        <div class="bg-white rounded-lg p-8 mb-12">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-normal text-[#6b6b6b] mb-2">
                        {{ $userResponse->name }}
                    </h2>
                    <p class="text-xl text-[#6b6b6b]">
                        {{ $userResponse->program }}
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-xl text-[#6b6b6b] mb-1">Budget Range</p>
                    <p class="text-2xl font-normal text-[#6b6b6b]">
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
            <div class="mb-12">
                <h2 class="text-[48px] font-light leading-[1] text-[#5a5858] mb-8">
                    REKOMENDASI<br/>LAPTOP
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($recommendations as $index => $laptop)
                        <div class="bg-white rounded-lg overflow-hidden {{ $index === 0 ? 'ring-2 ring-[#1e40af]' : '' }}">
                            @if($index === 0)
                                <div class="bg-[#1e40af] text-white text-center py-3">
                                    <span class="text-xl font-normal">REKOMENDASI TERBAIK</span>
                                </div>
                            @endif
                            
                            <!-- Laptop Image -->
                            <div class="bg-[#f3f1f0] p-8 flex items-center justify-center h-48">
                                @if($laptop->image)
                                    <img src="{{ Storage::url($laptop->image) }}" 
                                         alt="{{ $laptop->name }}" 
                                         class="max-h-full max-w-full object-contain">
                                @else
                                    <div class="text-[#6b6b6b] text-center">
                                        <i class="fas fa-laptop text-6xl mb-2"></i>
                                        <p class="text-xl">No Image</p>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Laptop Info -->
                            <div class="p-8">
                                <div class="mb-4">
                                    <span class="block text-2xl font-normal text-[#6b6b6b]">{{ $laptop->name }}</span>
                                </div>
                                
                                <!-- Price -->
                                <div class="mb-6">
                                    <span class="text-2xl font-normal text-[#6b6b6b]">
                                        Rp {{ number_format($laptop->price ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <!-- Specs -->
                                <div class="space-y-4 mb-6">
                                    <div class="flex items-center text-xl text-[#6b6b6b]">
                                        <span class="w-32">Processor:</span>
                                        <span>{{ $laptop->processor ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center text-xl text-[#6b6b6b]">
                                        <span class="w-32">RAM:</span>
                                        <span>{{ $laptop->ram ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center text-xl text-[#6b6b6b]">
                                        <span class="w-32">Storage:</span>
                                        <span>{{ $laptop->storage ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center text-xl text-[#6b6b6b]">
                                        <span class="w-32">GPU:</span>
                                        <span>{{ $laptop->gpu ?? 'N/A' }}</span>
                                    </div>
                                    @if(isset($laptop->screen_size))
                                    <div class="flex items-center text-xl text-[#6b6b6b]">
                                        <span class="w-32">Display:</span>
                                        <span>{{ $laptop->screen_size }}"</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Score/Rating -->
                                @if(isset($laptop->swara_score))
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xl text-[#6b6b6b]">Compatibility Score</span>
                                        <span class="text-xl font-normal">{{ number_format($laptop->swara_score * 100, 1) }}%</span>
                                    </div>
                                    <div class="w-full bg-[#d9d9d9] rounded-full h-2">
                                        <div class="bg-[#6b6b6b] h-2 rounded-full" 
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
            <div class="bg-white rounded-lg p-12 text-center">
                <div class="text-[#6b6b6b] mb-4">
                    <i class="fas fa-search text-6xl"></i>
                </div>
                <h3 class="text-2xl font-normal text-[#6b6b6b] mb-4">Tidak Ada Hasil</h3>
                <p class="text-xl text-[#6b6b6b] mb-6">Maaf, tidak ada laptop yang sesuai dengan kriteria Anda.</p>
                <a href="{{ route('user.form') }}" class="inline-flex items-center bg-[#6b6b6b] hover:bg-[#5a5858] text-white py-3 px-8 rounded-lg transition-colors duration-200">
                    <span class="text-xl">Coba Lagi</span>
                </a>
            </div>
        @endif

        <!-- Preferences Summary -->
        <div class="bg-white rounded-lg p-8 mb-12">
            <h2 class="text-[48px] font-light leading-[1] text-[#5a5858] mb-8">
                RINGKASAN<br/>PREFERENSI
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-[#f3f1f0] p-6 rounded-lg">
                    <h3 class="text-xl text-[#6b6b6b] mb-2">Budget</h3>
                    <p class="text-2xl font-normal text-[#6b6b6b]">
                        {{ $budgetRanges[$userResponse->budget] ?? $userResponse->budget }}
                    </p>
                </div>
                <div class="bg-[#f3f1f0] p-6 rounded-lg">
                    <h3 class="text-xl text-[#6b6b6b] mb-2">RAM</h3>
                    <p class="text-2xl font-normal text-[#6b6b6b]">{{ $userResponse->ram }}</p>
                </div>
                <div class="bg-[#f3f1f0] p-6 rounded-lg">
                    <h3 class="text-xl text-[#6b6b6b] mb-2">Storage</h3>
                    <p class="text-2xl font-normal text-[#6b6b6b]">{{ $userResponse->storage }}</p>
                </div>
                <div class="bg-[#f3f1f0] p-6 rounded-lg">
                    <h3 class="text-xl text-[#6b6b6b] mb-2">GPU</h3>
                    <p class="text-2xl font-normal text-[#6b6b6b]">{{ $userResponse->gpu }}</p>
                </div>
                <div class="bg-[#f3f1f0] p-6 rounded-lg">
                    <h3 class="text-xl text-[#6b6b6b] mb-2">Screen Size</h3>
                    <p class="text-2xl font-normal text-[#6b6b6b]">{{ $userResponse->screen }}</p>
                </div>
                <div class="bg-[#f3f1f0] p-6 rounded-lg">
                    <h3 class="text-xl text-[#6b6b6b] mb-2">Aktivitas Utama</h3>
                    <p class="text-2xl font-normal text-[#6b6b6b]">
                        @php
                            $activities = json_decode($userResponse->activities);
                            echo is_array($activities) ? implode(', ', $activities) : $activities;
                        @endphp
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="text-center space-x-6">
            <a href="{{ route('questions.index') }}" 
               class="inline-flex items-center bg-[#6b6b6b] hover:bg-[#5a5858] text-white py-3 px-8 rounded-lg transition-colors duration-200">
                <span class="text-xl">Cari Lagi</span>
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center bg-[#6b6b6b] hover:bg-[#5a5858] text-white py-3 px-8 rounded-lg transition-colors duration-200">
                <span class="text-xl">Cetak Hasil</span>
            </button>
            <button onclick="shareResults()" 
                    class="inline-flex items-center bg-[#6b6b6b] hover:bg-[#5a5858] text-white py-3 px-8 rounded-lg transition-colors duration-200">
                <span class="text-xl">Bagikan</span>
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
            .bg-[#f3f1f0] { background: white !important; }
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