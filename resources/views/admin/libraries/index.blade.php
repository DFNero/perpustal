{{-- resources\views\admin\libraries\index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Daftar Perpustakaan
        </h2>
    </x-slot>

    <div class="space-y-4">
        <div class="flex gap-2">
            <a href="{{ route('admin.libraries.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                + Tambah Perpustakaan
            </a>
            <a href="{{ route('libraries.map') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                🗺️ Lihat Peta
            </a>
        </div>

        @if($libraries->count())
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">#</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Nama</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Alamat</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Koordinat</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($libraries as $lib)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">{{ $lib->name }}</td>
                                <td class="px-6 py-3 text-gray-700 text-sm">{{ $lib->address }}</td>
                                <td class="px-6 py-3 text-gray-700 text-sm">{{ $lib->latitude }}, {{ $lib->longitude }}</td>
                                <td class="px-6 py-3 text-sm space-x-2">
                                    <a href="{{ route('admin.libraries.books.index', $lib) }}" class="text-blue-600 hover:underline">Kelola Buku</a>
                                    <a href="{{ route('admin.libraries.edit', $lib) }}" class="text-blue-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.libraries.destroy', $lib) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus perpustakaan ini?');">
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
                Belum ada perpustakaan.
            </div>
        @endif
    </div>
</x-app-layout>
