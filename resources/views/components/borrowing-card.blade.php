<!-- User Borrowing Card with Due Date Display -->
<div class="border rounded-lg p-6 hover:shadow-lg transition-shadow" :class="{
    'bg-green-50 border-green-200': '{{ $borrowing->getDueDateStatus() }}' === 'on-time',
    'bg-yellow-50 border-yellow-200': '{{ $borrowing->getDueDateStatus() }}' === 'warning',
    'bg-red-50 border-red-200': '{{ $borrowing->getDueDateStatus() }}' === 'overdue',
    'bg-gray-50 border-gray-200': !['on-time', 'warning', 'overdue'].includes('{{ $borrowing->getDueDateStatus() }}')
}">
    <!-- Book and Library Info -->
    <div class="mb-4">
        <h3 class="text-lg font-bold text-gray-900">{{ $borrowing->book->title }}</h3>
        <p class="text-sm text-gray-600">
            <strong>📖 Penulis:</strong> {{ $borrowing->book->author }}
        </p>
        <p class="text-sm text-gray-600">
            <strong>📍 Perpustakaan:</strong> {{ $borrowing->library->name }}
        </p>
    </div>

    <!-- Borrow Details -->
    <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
        <div>
            <p class="text-gray-500">Tanggal Dipinjam</p>
            <p class="font-semibold text-gray-900">
                {{ $borrowing->borrow_date?->format('d M Y') ?? '-' }}
            </p>
        </div>
        <div>
            <p class="text-gray-500">Status</p>
            <p class="font-semibold">
                @if ($borrowing->status === 'pending')
                    <span class="text-yellow-600">⏳ Pending</span>
                @elseif ($borrowing->status === 'approved')
                    <span class="text-green-600">✅ Approved</span>
                @elseif ($borrowing->status === 'returned')
                    <span class="text-blue-600">✓ Returned</span>
                @elseif ($borrowing->status === 'rejected')
                    <span class="text-red-600">❌ Rejected</span>
                @else
                    <span class="text-gray-600">{{ $borrowing->status }}</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Due Date Section (only show for approved borrowings) -->
    @if ($borrowing->status === 'approved' && $borrowing->due_date)
        <div class="border-t pt-4">
            <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-semibold text-gray-700">📅 Tanggal Kembali</span>
                
                <!-- Status Badge -->
                @php
                    $status = $borrowing->getDueDateStatus();
                    $badgeClass = match($status) {
                        'on-time' => 'bg-green-100 text-green-800 border-green-300',
                        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
                        'overdue' => 'bg-red-100 text-red-800 border-red-300',
                        default => 'bg-gray-100 text-gray-800 border-gray-300'
                    };
                @endphp

                <span class="px-3 py-1 text-xs font-semibold border rounded-full {{ $badgeClass }}">
                    @if ($status === 'on-time')
                        ✅ Tepat Waktu
                    @elseif ($status === 'warning')
                        ⚠️ Segera Dikembalikan
                    @elseif ($status === 'overdue')
                        ❌ Terlambat
                    @else
                        Unknown
                    @endif
                </span>
            </div>

            <!-- Due Date and Countdown -->
            <div class="space-y-2">
                <p class="text-sm text-gray-600">
                    <strong>Batas Kembali:</strong> <span class="text-base font-bold text-gray-900">{{ $borrowing->due_date->format('d F Y') }}</span>
                </p>

                <!-- Countdown Display -->
                <div class="text-center py-3 rounded-lg" :class="{
                    'bg-green-100': '{{ $status }}' === 'on-time',
                    'bg-yellow-100': '{{ $status }}' === 'warning',
                    'bg-red-100': '{{ $status }}' === 'overdue'
                }">
                    @if ($status === 'overdue')
                        <p class="text-sm text-red-600">
                            <strong>⏰ Terlambat</strong> {{ $borrowing->daysOverdue() }} hari
                        </p>
                        <p class="text-xs text-red-500 mt-1">
                            Harap segera kembalikan buku ini
                        </p>
                    @else
                        <p class="text-lg font-bold" :class="{
                            'text-green-700': '{{ $status }}' === 'on-time',
                            'text-yellow-700': '{{ $status }}' === 'warning'
                        }">
                            @if ($borrowing->daysUntilDue() === 0)
                                Hari Ini
                            @elseif ($borrowing->daysUntilDue() === 1)
                                Besok
                            @else
                                {{ $borrowing->daysUntilDue() }} hari lagi
                            @endif
                        </p>
                        <p class="text-xs mt-1" :class="{
                            'text-green-600': '{{ $status }}' === 'on-time',
                            'text-yellow-600': '{{ $status }}' === 'warning'
                        }">
                            {{ $borrowing->due_date->diffForHumans() }}
                        </p>
                    @endif
                </div>
            </div>

            <!-- Duration Info -->
            <p class="text-xs text-gray-500 mt-3 text-center">
                Durasi Peminjaman: {{ now()->diffInDays($borrowing->due_date) }} hari
            </p>
        </div>
    @endif

    <!-- Action Button: Cancel Borrow (only for pending) -->
    @if ($borrowing->status === 'pending')
        <div class="mt-4 pt-4 border-t">
            <form method="POST" action="{{ route('borrowings.cancel', $borrowing) }}" onsubmit="return confirm('Yakin ingin membatalkan pengajuan peminjaman ini?');">
                @csrf
                <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition-colors">
                    Batalkan Pengajuan
                </button>
            </form>
        </div>
    @endif
</div>
