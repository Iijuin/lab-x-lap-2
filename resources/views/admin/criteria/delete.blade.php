@extends('layouts.admin')

@section('title', 'Hapus Kriteria')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-center mb-6">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-5xl mb-4"></i>
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Konfirmasi Hapus</h1>
                <p class="text-gray-600">
                    Apakah Anda yakin ingin menghapus kriteria "{{ $criteria->name }}"?
                </p>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-md">
                    <h2 class="font-medium text-gray-700 mb-2">Detail Kriteria:</h2>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm text-gray-500">Nama</dt>
                            <dd class="text-gray-800">{{ $criteria->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Deskripsi</dt>
                            <dd class="text-gray-800">{{ $criteria->description }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500">Bobot</dt>
                            <dd class="text-gray-800">{{ $criteria->weight }}</dd>
                        </div>
                    </dl>
                </div>

                <form action="{{ route('admin.criteria.destroy', $criteria) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('DELETE')

                    <div class="flex space-x-4">
                        <a href="{{ route('admin.criteria.index') }}" 
                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-4 rounded-md text-center transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition-colors duration-200">
                            <i class="fas fa-trash-alt mr-2"></i>
                            Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 