@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Laptops Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <i class="fas fa-laptop text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Laptop</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalLaptops }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.laptops.index') }}" class="text-blue-600 hover:text-blue-800">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Responses Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-clipboard-list text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Respon</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalResponses }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.responses.index') }}" class="text-green-600 hover:text-green-800">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Total Criteria Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                        <i class="fas fa-list-check text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-gray-500 text-sm">Total Kriteria</h3>
                        <p class="text-2xl font-semibold text-gray-800">{{ $totalCriteria }}</p>
                    </div>
                </div>
                <a href="{{ route('admin.criteria.index') }}" class="text-purple-600 hover:text-purple-800">
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Laptop Stats -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Statistik Laptop</h2>
            <a href="{{ route('admin.laptops.index') }}" class="text-blue-600 hover:text-blue-800">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h3 class="text-sm text-gray-500">Harga Rendah</h3>
                <p class="text-2xl font-semibold text-gray-800">{{ $laptopStats['byPrice']['low'] }}</p>
                <p class="text-sm text-gray-500">(< Rp10.000.000)</p>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <h3 class="text-sm text-gray-500">Harga Menengah</h3>
                <p class="text-2xl font-semibold text-gray-800">{{ $laptopStats['byPrice']['medium'] }}</p>
                <p class="text-sm text-gray-500">(Rp10.000.000 - 15.000.000)</p>
            </div>
            <div class="bg-purple-50 p-4 rounded-lg">
                <h3 class="text-sm text-gray-500">Harga Tinggi</h3>
                <p class="text-2xl font-semibold text-gray-800">{{ $laptopStats['byPrice']['high'] }}</p>
                <p class="text-sm text-gray-500">(> Rp15.000.000)</p>
            </div>
        </div>
    </div>

    <!-- Recent Responses -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Respon Terbaru</h2>
            <a href="{{ route('admin.responses.index') }}" class="text-green-600 hover:text-green-800">
                Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        <div class="space-y-4">
            @forelse($recentResponses as $response)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-800">{{ $response->name }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $response->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-800">
                            Budget: {{ ucfirst(str_replace('-', ' ', $response->budget)) }}
                        </p>
                        <p class="text-sm text-gray-500">
                            {{ $response->program }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-center py-4">Belum ada rekomendasi</p>
            @endforelse
        </div>
    </div>
</div>
@endsection 