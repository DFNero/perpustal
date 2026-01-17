{{-- resources\views\admin\libraries\books\index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Kelola Buku di {{ $library->name }}
        </h2>
    </x-slot>

    <div class="space-y-4">
        <div class="flex gap-3">
            <a href="{{ route('admin.libraries.books.create', $library) }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                + Tambah Buku
            </a>
            <a href="{{ route('admin.libraries.index') }}" class="inline-block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                ← Kembali ke Perpustakaan
            </a>
        </div>

        @if($library->books->count())
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">#</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Judul Buku</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Penulis</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Stok</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($library->books as $book)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">{{ $book->title }}</td>
                                <td class="px-6 py-3 text-gray-700 text-sm">{{ $book->author }}</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">{{ $book->pivot->stock }}</td>
                                <td class="px-6 py-3 text-sm space-x-2">
                                    <a href="{{ route('admin.libraries.books.edit', [$library, $book]) }}" class="text-blue-600 hover:underline">Edit Stok</a>
                                    <form action="{{ route('admin.libraries.books.destroy', [$library, $book]) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus buku dari perpustakaan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white p-6 rounded-lg text-gray-500 text-center">
                Belum ada buku di perpustakaan ini.
            </div>
        @endif
    </div>
</x-app-layout>