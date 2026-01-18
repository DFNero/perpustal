{{-- resources/views/staff/books/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Kelola Buku
            </h2>
            <a href="{{ route('staff.books.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium">
                + Tambah Buku
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if($books->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($books as $book)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <!-- Cover Image -->
                        <div class="h-64 bg-gray-200 overflow-hidden flex items-center justify-center">
                            @if($book->cover_path)
                                <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="h-full w-full object-cover">
                            @else
                                <div class="text-gray-400 text-center p-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image mx-auto mb-2"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                    <p class="text-sm">Tidak ada cover</p>
                                </div>
                            @endif
                        </div>

                        <!-- Book Info -->
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-2">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-600 mb-1">{{ $book->author }}</p>
                            <p class="text-xs text-gray-500 mb-3">{{ $book->category->name ?? 'N/A' }}</p>

                            <!-- Actions -->
                            <div>
                                <a href="{{ route('staff.books.edit', $book) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm transition font-medium text-center block">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-12 rounded-lg text-gray-500 text-center">
                <p>Belum ada buku.</p>
            </div>
        @endif
    </div>
</x-app-layout>
