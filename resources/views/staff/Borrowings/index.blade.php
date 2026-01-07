<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Pengajuan Peminjaman
        </h2>
    </x-slot>

    <div class="p-6 space-y-4">
        @forelse ($borrowings as $b)
            <div class="border p-4 rounded flex justify-between items-center">
                <div>
                    <p class="font-bold">{{ $b->book->title }}</p>
                    <p>User: {{ $b->user->name }}</p>
                    <p>Perpustakaan: {{ $b->library->name }}</p>
                </div>

                <div class="flex gap-2">
                    @if (
                        $b->library->books
                            ->where('id', $b->book_id)
                            ->first()
                            ->pivot
                            ->stock > 0
                    )
                        <form method="POST" action="{{ route('staff.borrowings.approve', $b) }}">
                            @csrf
                            @method('PATCH')
                            <button class="bg-green-600 text-white px-3 py-1 rounded">
                                Approve
                            </button>
                        </form>
                    @else
                        <span class="text-red-600 text-sm">
                            Stok habis
                        </span>
                    @endif

                    <form method="POST" action="{{ route('staff.borrowings.reject', $b) }}">
                        @csrf
                        @method('PATCH')
                        <button class="bg-red-600 text-white px-3 py-1 rounded">
                            Reject
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p>Tidak ada pengajuan</p>
        @endforelse
    </div>
</x-app-layout>
