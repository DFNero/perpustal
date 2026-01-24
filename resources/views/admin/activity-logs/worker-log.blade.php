{{-- resources/views/admin/activity-logs/worker-log.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Log Aktivitas Staff & Admin
        </h2>
    </x-slot>

    <div class="space-y-4">
        {{-- Filters --}}
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('admin.activity-logs.worker') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Staff/Admin Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Staff/Admin</label>
                        <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua --</option>
                            @foreach ($workers as $worker)
                                <option value="{{ $worker->id }}" {{ request('user_id') == $worker->id ? 'selected' : '' }}>
                                    {{ $worker->name }} ({{ ucfirst($worker->role) }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Activity Type Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Aktivitas</label>
                        <select name="activity_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua --</option>
                            <optgroup label="Staff Actions">
                                <option value="staff_approve_borrow" {{ request('activity_type') === 'staff_approve_borrow' ? 'selected' : '' }}>Setujui Peminjaman</option>
                                <option value="staff_reject_borrow" {{ request('activity_type') === 'staff_reject_borrow' ? 'selected' : '' }}>Tolak Peminjaman</option>
                                <option value="staff_process_return" {{ request('activity_type') === 'staff_process_return' ? 'selected' : '' }}>Proses Pengembalian</option>
                                <option value="staff_add_book" {{ request('activity_type') === 'staff_add_book' ? 'selected' : '' }}>Tambah Buku</option>
                                <option value="staff_update_book" {{ request('activity_type') === 'staff_update_book' ? 'selected' : '' }}>Update Buku</option>
                                <option value="staff_add_book_to_library" {{ request('activity_type') === 'staff_add_book_to_library' ? 'selected' : '' }}>Tambah ke Perpustakaan</option>
                                <option value="staff_update_stock" {{ request('activity_type') === 'staff_update_stock' ? 'selected' : '' }}>Update Stok</option>
                                <option value="staff_remove_book_from_library" {{ request('activity_type') === 'staff_remove_book_from_library' ? 'selected' : '' }}>Hapus dari Perpustakaan</option>
                            </optgroup>
                            <optgroup label="Admin Actions">
                                <option value="admin_ban_user" {{ request('activity_type') === 'admin_ban_user' ? 'selected' : '' }}>Ban User</option>
                                <option value="admin_unban_user" {{ request('activity_type') === 'admin_unban_user' ? 'selected' : '' }}>Unban User</option>
                                <option value="admin_create_category" {{ request('activity_type') === 'admin_create_category' ? 'selected' : '' }}>Buat Kategori</option>
                                <option value="admin_delete_category" {{ request('activity_type') === 'admin_delete_category' ? 'selected' : '' }}>Hapus Kategori</option>
                                <option value="admin_manage_staff" {{ request('activity_type') === 'admin_manage_staff' ? 'selected' : '' }}>Kelola Staff</option>
                            </optgroup>
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
                    <a href="{{ route('admin.activity-logs.worker') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
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
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            {{-- Worker Name Badge --}}
                            <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded text-sm font-medium">
                                👤 {{ $activity->user->name }}
                            </span>

                            {{-- Activity Type Badge --}}
                            @if (str_starts_with($activity->activity_type, 'staff_'))
                                @if ($activity->activity_type === 'staff_approve_borrow')
                                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-medium">
                                        ✅ Setujui
                                    </span>
                                @elseif ($activity->activity_type === 'staff_reject_borrow')
                                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-sm font-medium">
                                        ❌ Tolak
                                    </span>
                                @elseif ($activity->activity_type === 'staff_process_return')
                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-medium">
                                        📤 Kembalian
                                    </span>
                                @else
                                    <span class="inline-block bg-cyan-100 text-cyan-800 px-3 py-1 rounded text-sm font-medium">
                                        📚 Manajemen Buku
                                    </span>
                                @endif
                            @else
                                <span class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded text-sm font-medium">
                                    ⚙️ Admin
                                </span>
                            @endif

                            <span class="text-sm text-gray-500">
                                {{ $activity->created_at->format('d M Y H:i') }}
                            </span>
                        </div>

                        <p class="text-gray-900 font-medium">{{ $activity->description }}</p>
                        
                        @if ($activity->metadata)
                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 p-2 rounded">
                                @foreach ($activity->metadata as $key => $value)
                                    <p><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ is_array($value) ? json_encode($value) : $value }}</p>
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
