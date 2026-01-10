<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Kategori
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-4">
                        Daftar Kategori
                    </h3>

                    @if ($categories->count())
                        <table class="w-full border text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-3 py-2 text-left">#</th>
                                    <th class="border px-3 py-2 text-left">Nama</th>
                                    <th class="border px-3 py-2 text-left">Slug</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td class="border px-3 py-2">{{ $loop->iteration }}</td>
                                        <td class="border px-3 py-2">{{ $category->name }}</td>
                                        <td class="border px-3 py-2 text-gray-500">{{ $category->slug }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-gray-500 text-sm">
                            Belum ada kategori.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
