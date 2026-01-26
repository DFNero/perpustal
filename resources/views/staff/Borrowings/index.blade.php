<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl">
                Pengajuan Peminjaman (Pending)
            </h2>
            <a href="{{ route('staff.borrowings.approved') }}" class="text-blue-600 hover:underline text-sm">
                📚 Lihat Pengembalian →
            </a>
        </div>
    </x-slot>

    <div class="p-6 space-y-4">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

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
                        <!-- Approve Button (opens duration selector modal) -->
                        <button 
                            type="button" 
                            onclick="openDurationModal({{ $b->id }})"
                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 transition-colors">
                            Approve
                        </button>

                        <!-- Duration Selector Modal -->
                        <x-duration-selector :borrowing="$b" />
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

                    <!-- Ban User Button -->
                    <button 
                        type="button" 
                        onclick="openBanModal({{ $b->user->id }})"
                        title="Ban user from system"
                        class="bg-gray-700 text-white px-3 py-1 rounded hover:bg-gray-800 transition-colors">
                        🚫 Ban
                    </button>

                    <!-- Ban Modal -->
                    <x-ban-modal :user="$b->user" />
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <p>Tidak ada pengajuan peminjaman yang menunggu.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
