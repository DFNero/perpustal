{{-- resources/views/staff/libraries/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Perpustakaan
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow overflow-hidden">
        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-4 border-b flex justify-end">
            <a href="{{ route('libraries.map') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                🗺️ Lihat Peta
            </a>
        </div>

        @if($libraries->isEmpty())
            <div class="p-6 text-center text-gray-500">
                <p>Tidak ada perpustakaan tersedia.</p>
            </div>
        @else
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">#</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Nama Perpustakaan</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Alamat</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Jumlah Buku</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($libraries as $library)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $library->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($library->address, 40) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-medium">
                                    {{ $library->books_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('staff.libraries.show', $library) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    Kelola Buku
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
