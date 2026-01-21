<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Daftar Buku
            </h2>
            <a href="{{ route('libraries.map') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition text-sm">
                🗺️ Lihat Lokasi Perpustakaan
            </a>
        </div>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        <!-- Search Box -->
        <div class="mb-8">
            <form action="{{ route('books.index') }}" method="GET" class="flex gap-2">
                <div class="flex-1 relative">
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari buku berdasarkan judul, penulis, atau ISBN..."
                        class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="{{ $search ?? '' }}"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-3 top-2.5 text-gray-400"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                </div>
                @if($search ?? false)
                    <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($books as $book)
                <a href="{{ route('books.show', $book) }}" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition transform hover:scale-105 h-full flex flex-col">
                        <!-- Cover Image -->
                        <div class="relative bg-gray-200 h-48 flex items-center justify-center overflow-hidden">
                            @if($book->cover_path)
                                <img src="{{ asset('storage/' . $book->cover_path) }}" 
                                     alt="{{ $book->title }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="text-6xl">📖</div>
                            @endif
                        </div>

                        <!-- Book Info -->
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h2 class="font-semibold text-gray-900 line-clamp-2 group-hover:text-blue-600">
                                    {{ $book->title }}
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">{{ $book->author }}</p>
                            </div>

                            <div class="mt-3 pt-3 border-t text-xs text-gray-500">
                                <p>{{ $book->category->name ?? '-' }}</p>
                                <p>{{ $book->year }}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Tidak ada buku tersedia</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
