{{-- resources\views\staff\borrowings\approved.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Pengembalian Buku (Approved)
        </h2>
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
                <div class="flex-1">
                    <p class="font-bold text-lg">{{ $b->book->title }}</p>
                    <p class="text-sm text-gray-600">
                        <strong>Penulis:</strong> {{ $b->book->author }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>User:</strong> {{ $b->user->name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Perpustakaan:</strong> {{ $b->library->name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <strong>Tanggal Persetujuan:</strong> {{ $b->borrow_date ? \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') : '-' }}
                    </p>
                </div>

                <div class="text-right space-y-2">
                    <div>
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm">
                            Disetujui
                        </span>
                    </div>
                    <!-- Return Button (opens condition form modal) -->
                    <button 
                        type="button" 
                        onclick="openReturnModal({{ $b->id }})"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition-colors">
                        Catat Pengembalian
                    </button>

                    <!-- Return Condition Form Modal -->
                    <x-return-condition-form :borrowing="$b" />

                    <!-- Ban User Button -->
                    <button 
                        type="button" 
                        onclick="openBanModal({{ $b->user->id }})"
                        title="Ban user from system"
                        class="w-full bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 transition-colors">
                        🚫 Ban User
                    </button>

                    <!-- Ban Modal -->
                    <x-ban-modal :user="$b->user" />
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <p>Tidak ada peminjaman yang disetujui.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
