<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800">📊 Statistik & Laporan</h2>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto space-y-6">
        <!-- Key Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Borrowings -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Peminjaman</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalBorrowings }}</p>
                    </div>
                    <div class="text-4xl">📚</div>
                </div>
            </div>

            <!-- Pending Borrowings -->
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Peminjaman Pending</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingBorrowings }}</p>
                    </div>
                    <div class="text-4xl">⏳</div>
                </div>
            </div>

            <!-- Total Users -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Pengguna</p>
                        <p class="text-3xl font-bold text-green-600">{{ $totalUsers }}</p>
                    </div>
                    <div class="text-4xl">👥</div>
                </div>
            </div>

            <!-- Total Books -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm">Total Buku</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalBooks }}</p>
                    </div>
                    <div class="text-4xl">📖</div>
                </div>
            </div>
        </div>

        <!-- Borrowing Status Breakdown -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Peminjaman</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">{{ $borrowingStatus['pending'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">Menunggu Persetujuan</p>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <p class="text-2xl font-bold text-green-600">{{ $borrowingStatus['approved'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">Disetujui</p>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ $borrowingStatus['returned'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">Dikembalikan</p>
                </div>
                <div class="text-center p-4 bg-red-50 rounded-lg">
                    <p class="text-2xl font-bold text-red-600">{{ $borrowingStatus['rejected'] }}</p>
                    <p class="text-sm text-gray-600 mt-1">Ditolak</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top 5 Most Borrowed Books -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📈 Buku Paling Dipinjam</h3>
                <div class="space-y-3">
                    @forelse($topBooks as $idx => $book)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                                    {{ $idx + 1 }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $book->title }}</p>
                                    <p class="text-xs text-gray-600">{{ $book->author }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-lg text-blue-600">{{ $book->borrowings_count }}</p>
                                <p class="text-xs text-gray-600">peminjaman</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-6">Tidak ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Top 5 Most Active Users -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">👥 Pengguna Paling Aktif</h3>
                <div class="space-y-3">
                    @forelse($topUsers as $idx => $user)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold">
                                    {{ $idx + 1 }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-lg text-green-600">{{ $user->borrowings_count }}</p>
                                <p class="text-xs text-gray-600">peminjaman</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-6">Tidak ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Books by Category -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📁 Buku per Kategori</h3>
            <div class="space-y-2">
                @forelse($booksPerCategory as $item)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-700">{{ $item->category->name ?? 'Tidak ada kategori' }}</span>
                        <div class="flex items-center gap-2">
                            <div class="w-32 bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($item->total / $totalBooks) * 100 }}%"></div>
                            </div>
                            <span class="text-sm font-bold text-gray-900">{{ $item->total }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-6">Tidak ada data</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">🔄 Aktivitas Terbaru</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700">Pengguna</th>
                            <th class="px-4 py-2 text-left text-gray-700">Buku</th>
                            <th class="px-4 py-2 text-left text-gray-700">Perpustakaan</th>
                            <th class="px-4 py-2 text-left text-gray-700">Status</th>
                            <th class="px-4 py-2 text-left text-gray-700">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($recentBorrowings as $borrowing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-gray-900">{{ $borrowing->user?->name ?? 'User Deleted' }}</td>
                                <td class="px-4 py-2 text-gray-900">{{ $borrowing->book?->title ?? 'Book Deleted' }}</td>
                                <td class="px-4 py-2 text-gray-900">{{ $borrowing->library?->name ?? 'Library Deleted' }}</td>
                                <td class="px-4 py-2">
                                    @if($borrowing->status === 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Pending</span>
                                    @elseif($borrowing->status === 'approved')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Approved</span>
                                    @elseif($borrowing->status === 'returned')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Returned</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-gray-600 text-xs">{{ $borrowing->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada aktivitas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
