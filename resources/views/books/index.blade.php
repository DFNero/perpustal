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
        <!-- Search & Filter Box -->
        <div class="mb-8">
            <form action="{{ route('books.index') }}" method="GET" class="space-y-4">
                <!-- Search -->
                <div class="flex gap-2">
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
                    @if(($search ?? false) || ($category ?? false) || ($year ?? false) || ($publisher ?? false))
                        <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded-lg transition">
                            Reset Semua
                        </a>
                    @endif
                </div>

                <!-- Filters -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <!-- Category Filter -->
                    <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $category == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Year Filter -->
                    <select name="year" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Publisher Filter -->
                    <select name="publisher" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" onchange="this.form.submit()">
                        <option value="">Semua Penerbit</option>
                        @foreach($publishers as $pub)
                            <option value="{{ $pub }}" {{ $publisher == $pub ? 'selected' : '' }}>
                                {{ $pub }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Active Filters Display -->
                @if(($search ?? false) || ($category ?? false) || ($year ?? false) || ($publisher ?? false))
                    <div class="flex flex-wrap gap-2">
                        @if($search ?? false)
                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                                🔍 Pencarian: "{{ $search }}"
                            </span>
                        @endif
                        @if($category ?? false)
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                📁 Kategori: "{{ $categories->find($category)->name ?? '' }}"
                            </span>
                        @endif
                        @if($year ?? false)
                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                                📅 Tahun: {{ $year }}
                            </span>
                        @endif
                        @if($publisher ?? false)
                            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm">
                                🏢 Penerbit: "{{ $publisher }}"
                            </span>
                        @endif
                    </div>
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

                            <div class="mt-3 pt-3 border-t space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">{{ $book->category->name ?? '-' }}</span>
                                    @if($book->averageRating() > 0)
                                        <span class="text-yellow-400 text-sm">★ {{ round($book->averageRating(), 1) }}</span>
                                    @else
                                        <span class="text-gray-400 text-xs">No rating</span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500">{{ $book->year }}</p>
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
