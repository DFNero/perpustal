{{-- resources\views\notifications\index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Notifikasi Peminjaman Saya
        </h2>
    </x-slot>

    <div class="p-6 space-y-4">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($notifications as $notif)
            <div class="border p-4 rounded {{ $notif->read_at ? 'bg-gray-50' : 'bg-blue-50' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        @php
                            $data = $notif->data;
                            $status = $data['status'] ?? 'unknown';
                            $bookTitle = $data['book_title'] ?? 'Buku';
                        @endphp

                        <p class="font-semibold text-lg">
                            @if ($status === 'approved')
                                ✅ Peminjaman Disetujui
                            @elseif ($status === 'rejected')
                                ❌ Peminjaman Ditolak
                            @elseif ($status === 'returned')
                                📚 Buku Diterima Kembali
                            @else
                                📢 Notifikasi
                            @endif
                        </p>

                        <p class="text-sm text-gray-700 mt-1">
                            Buku "<strong>{{ $bookTitle }}</strong>" 
                            @if ($status === 'approved')
                                telah disetujui untuk dipinjam.
                            @elseif ($status === 'rejected')
                                sayangnya ditolak.
                            @elseif ($status === 'returned')
                                sudah kami terima kembali.
                            @endif
                        </p>

                        <p class="text-xs text-gray-500 mt-2">
                            {{ $notif->created_at->format('d M Y H:i') }}
                            @if ($notif->read_at)
                                <span class="text-gray-400">(Sudah dibaca)</span>
                            @else
                                <span class="text-blue-600 font-semibold">(Baru)</span>
                            @endif
                        </p>
                    </div>

                    @if (!$notif->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notif->id) }}" style="display:inline">
                            @csrf
                            <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm">
                                Tandai Dibaca
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                <p>Anda belum memiliki notifikasi.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
