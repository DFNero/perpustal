{{-- resources/views/admin/users/create-staff.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Buat Akun Staff Baru
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.storeStaff') }}" class="space-y-4">
            @csrf

            {{-- Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Contoh: Budi Santoso"
                    required
                >
                @error('name')
                    <span class="text-red-600 text-sm block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="staff@perpustakaan.local"
                    required
                >
                @error('email')
                    <span class="text-red-600 text-sm block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input
                    type="password"
                    name="password"
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Minimal 8 karakter"
                    required
                >
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                @error('password')
                    <span class="text-red-600 text-sm block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Confirmation --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Ulangi password"
                    required
                >
                @error('password_confirmation')
                    <span class="text-red-600 text-sm block mt-1">{{ $message }}</span>
                @enderror
            </div>

            {{-- Role Info --}}
            <div class="p-4 bg-orange-50 border border-orange-200 rounded-lg">
                <p class="text-sm text-orange-900">
                    <strong>Role:</strong> Staff (Petugas Perpustakaan)
                </p>
                <p class="text-xs text-orange-700 mt-1">
                    Staff dapat mengelola buku, mengelola stok, dan memproses peminjaman.
                </p>
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3 pt-4">
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium"
                >
                    Buat Akun Staff
                </button>
                <a
                    href="{{ route('admin.users.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition font-medium"
                >
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
