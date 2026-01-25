{{-- resources\views\admin\libraries\index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Daftar Perpustakaan
        </h2>
    </x-slot>

    <div class="space-y-4">
        <!-- Search Box -->
        <form action="{{ route('admin.libraries.index') }}" method="GET" class="flex gap-2">
            <div class="flex-1 relative max-w-md">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari perpustakaan..."
                    class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ $search ?? '' }}"
                >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-3 top-2.5 text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </div>
            @if($search ?? false)
                <a href="{{ route('admin.libraries.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg transition">
                    Reset
                </a>
            @endif
        </form>

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
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Kota</th>
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
                                <td class="px-6 py-3 text-gray-900 font-medium">
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                        {{ $lib->city->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-900 font-medium">{{ $lib->name }}</td>
                                <td class="px-6 py-3 text-gray-700 text-sm">{{ Str::limit($lib->address, 30) }}</td>
                                <td class="px-6 py-3 text-gray-700 text-sm text-xs">{{ $lib->latitude }}, {{ $lib->longitude }}</td>
                                <td class="px-6 py-3 text-sm space-x-2">
                                    <a href="{{ route('admin.libraries.books.index', $lib) }}" class="text-blue-600 hover:underline">Buku</a>
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
