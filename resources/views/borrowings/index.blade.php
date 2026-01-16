{{-- resources\views\borrowings\index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Riwayat Peminjaman Saya
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

        @forelse ($borrowings as $b)
            <div class="border p-4 rounded flex justify-between items-center">
                <div>
                    <p class="font-bold">{{ $b->book->title }}</p>
                    <p class="text-sm text-gray-600">
                        Penulis: {{ $b->book->author }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Perpustakaan: {{ $b->library->name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Tanggal Pengajuan: {{ $b->created_at->format('d M Y') }}
                    </p>
                </div>

                {{-- STATUS --}}
                <div class="text-right">
                    @if ($b->status === 'pending')
                        <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm">
                            Menunggu Persetujuan
                        </span>
                    @elseif ($b->status === 'approved')
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm">
                            Disetujui
                        </span>
                        @if ($b->borrow_date)
                            <p class="text-xs text-gray-500 mt-2">
                                Dipinjam: {{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}
                            </p>
                        @endif
                    @elseif ($b->status === 'rejected')
                        <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-sm">
                            Ditolak
                        </span>
                    @elseif ($b->status === 'returned')
                        <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded text-sm">
                            Dikembalikan
                        </span>
                        @if ($b->return_date)
                            <p class="text-xs text-gray-500 mt-2">
                                Dikembalikan: {{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <p>Anda belum memiliki riwayat peminjaman.</p>
                <a href="{{ route('books.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Jelajahi Buku →
                </a>
            </div>
        @endforelse
    </div>
</x-app-layout>
