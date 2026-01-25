{{-- resources/views/staff/libraries/add-book.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Buku ke {{ $library->name }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        <!-- Progress Stats -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="grid grid-cols-3 gap-4 text-center">
                <div>
                    <p class="text-sm text-gray-600">Buku Ditambahkan</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $addedCount }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tersisa</p>
                    <p class="text-2xl font-bold text-green-600">{{ $remainingCount }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Buku</p>
                    <p class="text-2xl font-bold text-gray-600">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>

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

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded flex items-start gap-3">
                <span class="text-xl">⚠️</span>
                <div>
                    <strong>Tidak Bisa Ditambahkan</strong>
                    <p class="text-sm mt-1">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($availableBooks->isEmpty())
            <div class="p-6 text-center text-gray-500 bg-gray-50 rounded">
                <p class="text-lg font-medium">✓ Semua buku sudah ada di perpustakaan ini!</p>
                <p class="text-sm mt-2">Silakan manage stok atau pilih buku lain.</p>
                <a href="{{ route('staff.libraries.show', $library) }}" class="text-blue-600 hover:underline mt-4 block font-medium">
                    ← Kembali ke Daftar Buku
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('staff.libraries.store-book', $library) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Buku <span class="text-red-600">*</span></label>
                    <select name="book_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('book_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($availableBooks as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} - {{ $book->author }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-600">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 1) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required min="1">
                    @error('stock')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex gap-2 pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium">
                        Tambah Buku
                    </button>
                    <a href="{{ route('staff.libraries.show', $library) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition font-medium">
                        Batal
                    </a>
                </div>
            </form>
        @endif
    </div>
</x-app-layout>
