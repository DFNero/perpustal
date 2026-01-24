{{-- resources\views\borrowings\index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Riwayat Peminjaman Saya
        </h2>
    </x-slot>

    <div class="space-y-4">
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

        {{-- Status Filter --}}
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('borrowings.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Peminjaman</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                            <option value="returned" {{ request('status') === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('borrowings.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @forelse ($borrowings as $b)
            <div class="border p-4 rounded flex justify-between items-start bg-white shadow-sm hover:shadow-md transition">
                <div>
                    <p class="font-bold text-gray-900">{{ $b->book->title }}</p>
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

                {{-- STATUS & ACTIONS --}}
                <div class="text-right space-y-2">
                    @if ($b->status === 'pending')
                        <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm">
                            Menunggu Persetujuan
                        </span>
                        {{-- Cancel Button for Pending --}}
                        <form method="POST" action="{{ route('borrowings.cancel', $b) }}" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?');" 
                              class="inline-block">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium transition">
                                Batalkan
                            </button>
                        </form>
                    @elseif ($b->status === 'approved')
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm">
                            Disetujui
                        </span>
                        @if ($b->borrow_date)
                            <p class="text-xs text-gray-500">
                                Dipinjam: {{ \Carbon\Carbon::parse($b->borrow_date)->format('d M Y') }}
                            </p>
                        @endif
                        {{-- Cancel Button for Approved --}}
                        <form method="POST" action="{{ route('borrowings.cancel', $b) }}" 
                              onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?');" 
                              class="inline-block">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm font-medium transition">
                                Batalkan
                            </button>
                        </form>
                    @elseif ($b->status === 'rejected')
                        <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-sm">
                            Ditolak
                        </span>
                    @elseif ($b->status === 'returned')
                        <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded text-sm">
                            Dikembalikan
                        </span>
                        @if ($b->return_date)
                            <p class="text-xs text-gray-500">
                                Dikembalikan: {{ \Carbon\Carbon::parse($b->return_date)->format('d M Y') }}
                            </p>
                        @endif
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 bg-white rounded-lg">
                <p>Anda belum memiliki riwayat peminjaman.</p>
                <a href="{{ route('books.index') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                    Jelajahi Buku →
                </a>
            </div>
        @endforelse
    </div>
</x-app-layout>
