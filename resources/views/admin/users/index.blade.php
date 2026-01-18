{{-- resources/views/admin/users/index.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">
                Kelola User & Akun
            </h2>
            <a href="{{ route('admin.users.createStaff') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium">
                + Buat Akun Staff
            </a>
        </div>
    </x-slot>

    <div class="bg-white shadow-md rounded-lg p-6">
        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Nama</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Role</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Tanggal Daftar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            {{-- Name --}}
                            <td class="px-4 py-3 text-gray-900 font-medium">
                                {{ $user->name }}
                            </td>

                            {{-- Email --}}
                            <td class="px-4 py-3 text-gray-600 text-sm">
                                {{ $user->email }}
                            </td>

                            {{-- Role Badge --}}
                            <td class="px-4 py-3">
                                @if ($user->role === 'admin')
                                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-xs font-semibold">
                                        Admin
                                    </span>
                                @elseif ($user->role === 'staff')
                                    <span class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded text-xs font-semibold">
                                        Staff
                                    </span>
                                @else
                                    <span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded text-xs font-semibold">
                                        User
                                    </span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td class="px-4 py-3">
                                @if ($user->isBanned())
                                    <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded text-xs font-semibold">
                                        🔒 Banned
                                    </span>
                                    @if ($user->ban_until)
                                        <p class="text-xs text-red-600 mt-1">
                                            Sampai: {{ $user->ban_until->format('d M Y H:i') }}
                                        </p>
                                    @endif
                                    @if ($user->banned_reason)
                                        <p class="text-xs text-gray-500 mt-1">
                                            Alasan: {{ $user->banned_reason }}
                                        </p>
                                    @endif
                                @else
                                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded text-xs font-semibold">
                                        ✓ Aktif
                                    </span>
                                @endif
                            </td>

                            {{-- Created Date --}}
                            <td class="px-4 py-3 text-gray-600 text-sm">
                                {{ $user->created_at->format('d M Y') }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-4 py-3 text-sm">
                                <div class="flex gap-2 items-center">
                                    @if (!$user->isBanned() && $user->role === 'user')
                                        @php
                                            $activeBorrowings = $user->borrowings->count();
                                        @endphp
                                        
                                        @if ($activeBorrowings > 0)
                                            <button
                                                disabled
                                                title="Tidak bisa ban user yang sedang meminjam ({{ $activeBorrowings }} peminjaman aktif)"
                                                class="text-gray-400 cursor-not-allowed text-xs opacity-50"
                                            >
                                                Ban
                                            </button>
                                        @else
                                            <button
                                                onclick="document.getElementById('banModal{{ $user->id }}').style.display='flex'"
                                                class="text-red-600 hover:text-red-800 font-medium transition text-xs"
                                            >
                                                Ban
                                            </button>
                                        @endif
                                    @elseif ($user->isBanned())
                                        <form method="POST" action="{{ route('admin.users.unban', $user) }}" style="display:inline">
                                            @csrf
                                            <button
                                                type="submit"
                                                class="text-green-600 hover:text-green-800 font-medium transition text-xs"
                                                onclick="return confirm('Unban user ini?')"
                                            >
                                                Unban
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        {{-- Ban Modal for this user --}}
                        <div id="banModal{{ $user->id }}" style="display:none" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                            <div class="bg-white rounded-lg shadow-xl p-6 w-96 max-w-full">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ban User: {{ $user->name }}</h3>

                                <form method="POST" action="{{ route('admin.users.ban', $user) }}">
                                    @csrf

                                    <div class="space-y-4">
                                        {{-- Duration --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Durasi Ban
                                            </label>
                                            <select name="duration" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                                                <option value="1">1 Hari</option>
                                                <option value="7" selected>7 Hari</option>
                                                <option value="30">30 Hari</option>
                                                <option value="permanent">Selamanya</option>
                                            </select>
                                        </div>

                                        {{-- Reason --}}
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                                Alasan Ban
                                            </label>
                                            <textarea
                                                name="reason"
                                                class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 h-20"
                                                placeholder="Contoh: Melanggar tata tertib, spam, dll"
                                                required
                                            ></textarea>
                                        </div>
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="flex gap-3 mt-6">
                                        <button
                                            type="submit"
                                            class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition font-medium"
                                        >
                                            Ban User
                                        </button>
                                        <button
                                            type="button"
                                            onclick="document.getElementById('banModal{{ $user->id }}').style.display='none'"
                                            class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-lg transition font-medium"
                                        >
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                                Tidak ada user
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
