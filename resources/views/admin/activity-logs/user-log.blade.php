{{-- resources/views/admin/activity-logs/user-log.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Log Aktivitas User (Buku)
        </h2>
    </x-slot>

    <div class="space-y-4">
        {{-- Filters --}}
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <form method="GET" action="{{ route('admin.activity-logs.user') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- User Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">User</label>
                        <select name="user_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua User --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Activity Type Filter --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Aktivitas</label>
                        <select name="activity_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Semua --</option>
                            <option value="user_borrow" {{ request('activity_type') === 'user_borrow' ? 'selected' : '' }}>Peminjaman</option>
                            <option value="user_cancel_borrow" {{ request('activity_type') === 'user_cancel_borrow' ? 'selected' : '' }}>Pembatalan</option>
                            <option value="user_return_request" {{ request('activity_type') === 'user_return_request' ? 'selected' : '' }}>Pengembalian</option>
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

                {{-- Search Box --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Buku</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama buku..." 
                        class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Terapkan Filter
                    </button>
                    <a href="{{ route('admin.activity-logs.user') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Activities List --}}
        @forelse ($activities as $activity)
            <div class="border-l-4 border-blue-500 bg-white p-4 rounded-r-lg shadow-sm">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2 flex-wrap">
                            {{-- User Name Badge --}}
                            <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded text-sm font-medium">
                                👤 {{ $activity->user->name }}
                            </span>

                            {{-- Activity Type Badge --}}
                            @if ($activity->activity_type === 'user_borrow')
                                <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-medium">
                                    📥 Peminjaman
                                </span>
                            @elseif ($activity->activity_type === 'user_cancel_borrow')
                                <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-sm font-medium">
                                    ❌ Pembatalan
                                </span>
                            @elseif ($activity->activity_type === 'user_return_request')
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-sm font-medium">
                                    📤 Pengembalian
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
