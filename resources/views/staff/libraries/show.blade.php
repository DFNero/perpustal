{{-- resources/views/staff/libraries/show.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $library->name }}
            </h2>
            <a href="{{ route('staff.libraries.add-book-form', $library) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium">
                + Tambah Buku ke Perpustakaan
            </a>
        </div>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Library Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Alamat</p>
                    <p class="text-lg text-gray-900">{{ $library->address }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Koordinat</p>
                    <p class="text-lg text-gray-900">{{ $library->latitude }}, {{ $library->longitude }}</p>
                </div>
            </div>
        </div>

        <!-- Books in Library -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            @if(session('success'))
                <div class="p-4 bg-green-100 border-b border-green-400 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if($books->isEmpty())
                <div class="p-6 text-center text-gray-500">
                    <p>Belum ada buku di perpustakaan ini. <a href="{{ route('staff.libraries.add-book-form', $library) }}" class="text-blue-600 hover:underline">Tambah buku sekarang</a></p>
                </div>
            @else
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">#</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Judul Buku</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Penulis</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Kategori</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Stok</th>
                            <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $book)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $book->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $book->author }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $book->category->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs font-medium">
                                        {{ $book->pivot->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <a href="{{ route('staff.libraries.edit-stock-form', [$library, $book]) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Edit Stok
                                    </a>
                                    <form action="{{ route('staff.libraries.remove-book', [$library, $book]) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus buku dari perpustakaan?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Back Button -->
        <div>
            <a href="{{ route('staff.libraries.index') }}" class="text-blue-600 hover:underline">
                ← Kembali ke Daftar Perpustakaan
            </a>
        </div>
    </div>
</x-app-layout>
