<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Daftar Kategori
        </h2>
    </x-slot>

    <div class="space-y-4">
        <!-- Search Box -->
        <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2">
            <div class="flex-1 relative">
                <input
                    type="text"
                    name="search"
                    placeholder="Cari kategori..."
                    class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    value="{{ $search ?? '' }}"
                >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-3 top-2.5 text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
            </div>
            @if($search ?? false)
                <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg transition">
                    Reset
                </a>
            @endif
        </form>

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
