{{-- resources/views/admin/libraries/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Perpustakaan
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.libraries.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span class="text-red-600">*</span></label>
                <select name="city_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('city_id') border-red-500 @enderror" required>
                    <option value="">-- Pilih Kota --</option>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('city_id') == $city->id ? 'selected' : '' }}>
                            {{ $city->name }}
                        </option>
                    @endforeach
                </select>
                @error('city_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perpustakaan <span class="text-red-600">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat <span class="text-red-600">*</span></label>
                <textarea name="address" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 h-20 @error('address') border-red-500 @enderror" required>{{ old('address') }}</textarea>
                @error('address')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Latitude <span class="text-red-600">*</span></label>
                    <input type="text" name="latitude" value="{{ old('latitude') }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('latitude') border-red-500 @enderror" required>
                    <p class="text-xs text-gray-500 mt-1">Format: -90 hingga 90</p>
                    @error('latitude')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Longitude <span class="text-red-600">*</span></label>
                    <input type="text" name="longitude" value="{{ old('longitude') }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('longitude') border-red-500 @enderror" required>
                    <p class="text-xs text-gray-500 mt-1">Format: -180 hingga 180</p>
                    @error('longitude')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium">
                    Simpan Perpustakaan
                </button>
                <a href="{{ route('admin.libraries.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
