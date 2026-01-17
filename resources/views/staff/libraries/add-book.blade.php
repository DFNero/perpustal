{{-- resources/views/staff/libraries/add-book.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Buku ke {{ $library->name }}
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

        @if($availableBooks->isEmpty())
            <div class="p-6 text-center text-gray-500">
                <p>Semua buku sudah ada di perpustakaan ini.</p>
                <a href="{{ route('staff.libraries.show', $library) }}" class="text-blue-600 hover:underline mt-4 block">
                    Kembali ke Daftar Buku
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('staff.libraries.store-book', $library) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Buku <span class="text-red-600">*</span></label>
                    <select name="book_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
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
