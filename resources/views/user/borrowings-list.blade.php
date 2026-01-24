{{-- resources/views/user/borrowings-list.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Daftar Peminjaman Aktif
        </h2>
    </x-slot>

    <div class="space-y-4">
        {{-- Alerts --}}
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
            <form method="GET" action="{{ route('borrowings-list.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Peminjaman</label>
                        <select name="status" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Disetujui</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('borrowings-list.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Borrowings List --}}
        @forelse ($borrowings as $borrow)
            <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-blue-500">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Book Info --}}
                    <div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $borrow->book->title }}</h3>
                        <p class="text-sm text-gray-600">Penulis: {{ $borrow->book->author }}</p>
                        <p class="text-sm text-gray-600">Perpustakaan: {{ $borrow->library->name }}</p>
                        <p class="text-sm text-gray-600">Alamat: {{ $borrow->library->address }}</p>
                    </div>

                    {{-- Status & Dates --}}
                    <div>
                        <div class="mb-3">
                            @if ($borrow->status === 'pending')
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm font-medium">
                                    ⏳ Menunggu Persetujuan
                                </span>
                            @elseif ($borrow->status === 'approved')
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-medium">
                                    ✅ Disetujui
                                </span>
                                @if ($borrow->borrow_date)
                                    <p class="text-xs text-gray-600 mt-2">
                                        Dipinjam: {{ $borrow->borrow_date->format('d M Y') }}
                                    </p>
                                @endif
                            @elseif ($borrow->status === 'rejected')
                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-sm font-medium">
                                    ❌ Ditolak
                                </span>
                            @endif
                        </div>

                        {{-- Approval Info --}}
                        @if ($borrow->staff)
                            <p class="text-xs text-gray-500">
                                Diproses oleh: {{ $borrow->staff->name }}
                            </p>
                        @endif

                        <p class="text-xs text-gray-500 mt-2">
                            Diajukan: {{ $borrow->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col justify-between items-end gap-2">
                        {{-- Cancel Button (only for pending & approved) --}}
                        @if (in_array($borrow->status, ['pending', 'approved']))
                            <form method="POST" action="{{ route('borrowings.cancel', $borrow) }}" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan peminjaman ini?');" 
                                  class="w-full">
                                @csrf
                                <textarea name="cancel_reason" placeholder="Alasan pembatalan (opsional)" 
                                         class="w-full border-gray-300 rounded-md text-sm mb-2 focus:border-red-500 focus:ring-red-500"
                                         rows="2" maxlength="500"></textarea>
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-md text-sm font-medium transition">
                                    Batalkan Peminjaman
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-600 px-3 py-2 rounded-md text-sm font-medium cursor-not-allowed">
                                Tidak dapat dibatalkan
                            </button>
                        @endif

                        {{-- View Details Link --}}
                        <a href="{{ route('books.show', $borrow->book) }}" 
                           class="w-full text-center bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-2 rounded-md text-sm font-medium transition">
                            Lihat Buku
                        </a>
                    </div>
                </div>

                {{-- Notes --}}
                @if ($borrow->notes)
                    <div class="mt-4 p-3 bg-gray-50 rounded border border-gray-200">
                        <p class="text-xs font-medium text-gray-700 mb-1">Catatan:</p>
                        <p class="text-sm text-gray-600">{{ $borrow->notes }}</p>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-lg">
                <p class="text-gray-500 mb-4">Tidak ada peminjaman aktif.</p>
                <a href="{{ route('books.index') }}" class="text-blue-600 hover:underline">
                    Jelajahi Buku →
                </a>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $borrowings->links() }}
        </div>
    </div>
</x-app-layout>
