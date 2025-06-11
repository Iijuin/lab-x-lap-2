<!-- In your <head> section -->
<link href="https://fonts.googleapis.com/css2?family=Martian+Mono:wght@400;700&family=Xanh+Mono&display=swap" rel="stylesheet">

@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-6 py-6 font-martian">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- LEFT COLUMN -->
        <div class="space-y-4 col-span-1">
            <!-- Statistik Laptop -->
            <div class="border rounded-md p-4 bg-white">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="font-bold uppercase text-sm font-xanh">Statistik Laptop</h2>
                    <a href="{{ route('admin.laptops.index') }}">
                        <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>
                <div class="text-sm text-gray-600">
                    <div class="flex justify-between py-1 border-b">
                        <span>Harga Rendah</span><span>{{ $laptopStats['byPrice']['low'] }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b">
                        <span>Harga Sedang</span><span>{{ $laptopStats['byPrice']['medium'] }}</span>
                    </div>
                    <div class="flex justify-between py-1 border-b">
                        <span>Harga Tinggi</span><span>{{ $laptopStats['byPrice']['high'] }}</span>
                    </div>
                </div>
                <div class="border mt-4 rounded-full py-2 px-3 text-sm text-center text-gray-800">
                    Total Laptop <strong>{{ $totalLaptops }}</strong>
                </div>
            </div>

            <!-- Total Kriteria -->
            <div class="border rounded-md p-4 bg-white flex items-center justify-between">
                <div>
                    <p class="uppercase text-sm font-xanh">Total Kriteria</p>
                    <p class="text-2xl font-bold">{{ $totalCriteria }}</p>
                </div>
                <a href="{{ route('admin.criteria.index') }}">
                    <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                </a>
            </div>

            <!-- Total Respon -->
            <div class="border rounded-md p-4 bg-white flex items-center justify-between">
                <div>
                    <p class="uppercase text-sm font-xanh">Total Respon</p>
                    <p class="text-2xl font-bold">{{ $totalResponses }}</p>
                </div>
                <a href="{{ route('admin.responses.index') }}">
                    <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                </a>
            </div>
        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-span-2">
            <div class="border rounded-md p-4 bg-white h-full">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="uppercase font-bold text-sm font-xanh">Respon Terbaru</h2>
                    <a href="{{ route('admin.responses.index') }}">
                        <i class="fas fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                </div>
                @if(count($recentResponses))
                    <div class="space-y-3">
                        @foreach($recentResponses as $response)
                            <div class="p-3 border rounded-md flex justify-between items-center bg-gray-50">
                                <div>
                                    <p class="font-medium">{{ $response->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $response->created_at->format('d M Y, H:i') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-medium">Budget: {{ ucfirst(str_replace('-', ' ', $response->budget)) }}</p>
                                    <p class="text-sm text-gray-500">{{ $response->program }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-400 mt-8">Belum ada rekomendasi</p>
                @endif
            </div>
        </div>
    </div>
<<<<<<< HEAD

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
                            Budget: 
                            @php
                                $budgetRanges = [
                                    'less-5m' => 'Di bawah Rp5.000.000',
                                    '5m-8m' => 'Rp5.000.000 - Rp8.000.000',
                                    '8m-12m' => 'Rp8.000.000 - Rp12.000.000',
                                    '12m-15m' => 'Rp12.000.000 - Rp15.000.000',
                                    'more-15m' => 'Di atas Rp15.000.000'
                                ];
                            @endphp
                            {{ $budgetRanges[$response->budget] ?? $response->budget }}
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
=======
>>>>>>> c0f83ff1020491b0892bd13129ef23db5ce92061
</div>
