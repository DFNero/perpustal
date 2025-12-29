<x-app-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Daftar Buku</h1>

        <div class="grid grid-cols-4 gap-4">
            @foreach($books as $book)
                <a href="{{ route('books.show', $book) }}" class="border p-4 rounded">
                    <h2 class="font-semibold">{{ $book->title }}</h2>
                    <p class="text-sm text-gray-500">{{ $book->author }}</p>
                </a>
            @endforeach
        </div>
    </div>
</x-app-layout>
