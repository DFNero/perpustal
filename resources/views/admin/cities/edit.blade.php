@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.cities.index') }}" class="text-blue-600 hover:text-blue-800 font-medium mb-4 inline-block">
                ← Kembali ke Daftar Kota
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Kota</h1>
            <p class="text-gray-600 mt-2">Perbarui informasi kota: {{ $city->name }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.cities.update', $city) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Nama Kota -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kota/Kabupaten</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $city->name) }}"
                        placeholder="Contoh: Surabaya, Sidoarjo, Gresik"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Latitude -->
                <div class="mb-6">
                    <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                    <input 
                        type="number" 
                        id="latitude" 
                        name="latitude" 
                        value="{{ old('latitude', $city->latitude) }}"
                        step="0.00000001"
                        min="-90"
                        max="90"
                        placeholder="Contoh: -7.2575"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('latitude') border-red-500 @enderror"
                    >
                    @error('latitude')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">📍 Format: -90 hingga 90</p>
                </div>

                <!-- Longitude -->
                <div class="mb-6">
                    <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                    <input 
                        type="number" 
                        id="longitude" 
                        name="longitude" 
                        value="{{ old('longitude', $city->longitude) }}"
                        step="0.00000001"
                        min="-180"
                        max="180"
                        placeholder="Contoh: 112.7521"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('longitude') border-red-500 @enderror"
                    >
                    @error('longitude')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                    <p class="text-gray-500 text-xs mt-1">📍 Format: -180 hingga 180</p>
                </div>

                <!-- Help Text -->
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <p class="text-sm text-blue-900">
                        <strong>💡 Tips:</strong> Gunakan Google Maps untuk mencari koordinat. Cari nama kota di Google Maps, klik untuk melihat latitude dan longitude di URL.
                    </p>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition"
                    >
                        Simpan Perubahan
                    </button>
                    <a 
                        href="{{ route('admin.cities.index') }}" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-900 font-bold py-2 px-6 rounded-lg shadow-md transition"
                    >
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
