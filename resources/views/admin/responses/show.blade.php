@extends('layouts.admin')

@section('title', 'Detail Hasil Rekomendasi')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.responses.index') }}" class="text-blue-600 hover:text-blue-900">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">
                <i class="fas fa-clipboard-list mr-2"></i>
                Detail Hasil Rekomendasi
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Informasi User</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Nama:</span>
                            <p class="text-gray-800">{{ $response->name }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Jurusan:</span>
                            <p class="text-gray-800">{{ $response->program }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Tanggal:</span>
                            <p class="text-gray-800">{{ $response->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Preferensi</h2>
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-500">Aktivitas:</span>
                            <p class="text-gray-800">{{ $response->activities }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Budget:</span>
                            <p class="text-gray-800">{{ str_replace(['-', 'm'], [' - ', ' juta'], $response->budget) }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">RAM:</span>
                            <p class="text-gray-800">{{ $response->ram }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Storage:</span>
                            <p class="text-gray-800">{{ $response->storage }}</p>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">GPU:</span>
                            <p class="text-gray-800">{{ $response->gpu }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Rekomendasi Laptop</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($response->recommendations as $recommendation)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    {{ $recommendation->laptop->name }}
                                </h3>
                                <span class="text-sm font-medium text-blue-600">
                                    {{ number_format((float)$recommendation->score * 100, 1) }}%
                                </span>
                            </div>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Processor:</span> {{ $recommendation->laptop->processor }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">RAM:</span> {{ $recommendation->laptop->ram }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Storage:</span> {{ $recommendation->laptop->storage }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">GPU:</span> {{ $recommendation->laptop->gpu }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Harga:</span> Rp {{ number_format((float)$recommendation->laptop->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-500">
                            Tidak ada rekomendasi laptop
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 