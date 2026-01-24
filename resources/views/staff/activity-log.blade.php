{{-- resources/views/staff/activity-log.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Riwayat Aktivitas Saya
        </h2>
    </x-slot>

    <div class="space-y-4">
        {{-- Alerts --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('staff.activity-log.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Activity Type Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Aktivitas</label>
                        <select name="activity_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua Aktivitas --</option>
                            <option value="staff_approve_borrow" {{ request('activity_type') === 'staff_approve_borrow' ? 'selected' : '' }}>Persetujuan Peminjaman</option>
                            <option value="staff_reject_borrow" {{ request('activity_type') === 'staff_reject_borrow' ? 'selected' : '' }}>Penolakan Peminjaman</option>
                            <option value="staff_process_return" {{ request('activity_type') === 'staff_process_return' ? 'selected' : '' }}>Proses Pengembalian</option>
                            <option value="staff_add_book" {{ request('activity_type') === 'staff_add_book' ? 'selected' : '' }}>Tambah Buku</option>
                            <option value="staff_update_book" {{ request('activity_type') === 'staff_update_book' ? 'selected' : '' }}>Update Buku</option>
                            <option value="staff_add_book_to_library" {{ request('activity_type') === 'staff_add_book_to_library' ? 'selected' : '' }}>Tambah Buku ke Perpustakaan</option>
                            <option value="staff_update_stock" {{ request('activity_type') === 'staff_update_stock' ? 'selected' : '' }}>Update Stok</option>
                            <option value="staff_remove_book_from_library" {{ request('activity_type') === 'staff_remove_book_from_library' ? 'selected' : '' }}>Hapus Buku dari Perpustakaan</option>
                        </select>
                    </div>

                    {{-- Date From --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Dari Tanggal</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    {{-- Date To --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sampai Tanggal</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('staff.activity-log.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Activities List --}}
        @forelse ($activities as $activity)
            <div class="border-l-4 border-purple-500 bg-white p-4 rounded-r-lg shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            {{-- Activity Type Badge --}}
                            @if ($activity->activity_type === 'staff_approve_borrow')
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-medium">
                                    ✅ Setujui Peminjaman
                                </span>
                            @elseif ($activity->activity_type === 'staff_reject_borrow')
                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-sm font-medium">
                                    ❌ Tolak Peminjaman
                                </span>
                            @elseif ($activity->activity_type === 'staff_process_return')
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-medium">
                                    📤 Proses Pengembalian
                                </span>
                            @elseif (str_starts_with($activity->activity_type, 'staff_add_book') || str_starts_with($activity->activity_type, 'staff_update_book'))
                                <span class="inline-block bg-cyan-100 text-cyan-800 px-3 py-1 rounded text-sm font-medium">
                                    📚 Manajemen Buku
                                </span>
                            @elseif (str_starts_with($activity->activity_type, 'staff_update_stock') || str_starts_with($activity->activity_type, 'staff_remove_book'))
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded text-sm font-medium">
                                    📦 Manajemen Stok
                                </span>
                            @endif

                            <span class="text-sm text-gray-500">
                                {{ $activity->created_at->format('d M Y H:i') }}
                            </span>
                        </div>

                        <p class="text-gray-900 font-medium">{{ $activity->description }}</p>
                        
                        @if ($activity->activity_type === 'staff_update_stock' && $activity->metadata && $activity->metadata['reason'])
                            <div class="mt-2 text-sm text-gray-700 bg-blue-50 p-3 rounded border-l-4 border-blue-500">
                                <p><strong>💬 Alasan:</strong> {{ $activity->metadata['reason'] }}</p>
                            </div>
                        @endif
                        
                        @if ($activity->metadata)
                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                @foreach ($activity->metadata as $key => $value)
                                    @if ($key !== 'reason')
                                        <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}</p>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500 bg-white rounded-lg">
                <p>Tidak ada aktivitas yang ditemukan.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</x-app-layout>
