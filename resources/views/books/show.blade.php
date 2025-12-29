<x-app-layout>
    <h1 class="text-2xl font-bold">{{ $book->title }}</h1>

    <p class="mt-2 text-gray-600">{{ $book->description }}</p>

    @auth
        @php
            $pending = auth()->user()
                ->borrowings()
                ->where('book_id', $book->id)
                ->where('status', 'pending')
                ->exists();
        @endphp

        @if($pending)
            <button class="mt-4 bg-yellow-400 text-black px-4 py-2 rounded">
                Pending Review
            </button>
        @else
            <form method="POST" action="{{ route('borrow.store', $book) }}">
                @csrf
                <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                    Ajukan Peminjaman
                </button>
            </form>
        @endif
    @endauth
</x-app-layout>
