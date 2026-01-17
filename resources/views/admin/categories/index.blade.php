<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Daftar Kategori
        </h2>
    </x-slot>

    <div class="space-y-4">
        <a href="{{ route('admin.categories.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
            + Tambah Kategori
        </a>

        <div class="space-y-2">
            @forelse ($categories as $category)
                <div class="bg-white p-4 rounded-lg flex justify-between items-center shadow-sm hover:shadow-md transition">
                    <span class="text-gray-900 font-medium">{{ $category->name }}</span>
                    <div class="space-x-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:underline text-sm">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus kategori ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white p-6 rounded-lg text-gray-500 text-center">
                    Belum ada kategori
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
