{{-- resources\views\admin\libraries\books\all.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Kelola Buku per Perpustakaan
        </h2>
    </x-slot>

    <div class="space-y-4">
        <p class="text-gray-600">Pilih perpustakaan untuk mengelola buku-bukunya:</p>

        @if($libraries->count())
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-300">
                        <tr>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">#</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Nama Perpustakaan</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Alamat</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Jumlah Buku</th>
                            <th class="text-left px-6 py-3 font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($libraries as $lib)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-gray-900">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">{{ $lib->name }}</td>
                                <td class="px-6 py-3 text-gray-700 text-sm">{{ $lib->address }}</td>
                                <td class="px-6 py-3 text-gray-900 font-medium">{{ $lib->books->count() }}</td>
                                <td class="px-6 py-3 text-sm">
                                    <a href="{{ route('admin.libraries.books.index', $lib) }}" class="text-blue-600 hover:underline">Kelola Buku</a>
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
