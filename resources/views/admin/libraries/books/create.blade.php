{{-- resources\views\admin\libraries\books\create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Tambah Buku ke {{ $library->name }}
        </h2>
    </x-slot>

    <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
        <!-- Progress Stats -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="grid grid-cols-3 gap-4 text-center text-sm">
                <div>
                    <p class="text-gray-600 text-xs">Ditambahkan</p>
                    <p class="text-lg font-bold text-blue-600">{{ $addedCount }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-xs">Tersisa</p>
                    <p class="text-lg font-bold text-green-600">{{ $remainingCount }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-xs">Total</p>
                    <p class="text-lg font-bold text-gray-600">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded text-sm">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded flex items-start gap-2 text-sm">
                <span class="text-lg">⚠️</span>
                <div>
                    <strong>Tidak Bisa Ditambahkan</strong>
                    <p class="mt-1">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($books->isEmpty())
            <div class="p-6 text-center text-gray-500 bg-gray-50 rounded text-sm">
                <p class="font-medium">✓ Semua buku sudah ada!</p>
                <a href="{{ route('admin.libraries.books.index', $library) }}" class="text-blue-600 hover:underline mt-3 block">
                    ← Kembali
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('admin.libraries.books.store', $library) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Buku <span class="text-red-600">*</span></label>
                    <select name="book_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('book_id') border-red-500 @enderror" required>
                        <option value="">-- Pilih Buku ({{ $books->count() }} tersedia) --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} - {{ $book->author }}
                            </option>
                        @endforeach
                    </select>
                    @error('book_id')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stok <span class="text-red-600">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stock') border-red-500 @enderror" required min="0">
                    @error('stock')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium text-sm">
                        Tambah Buku
                    </button>
                    <a href="{{ route('admin.libraries.books.index', $library) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition font-medium text-sm">
                        Batal
                    </a>
                </div>
            </form>
        @endif
    </div>
</x-app-layout>