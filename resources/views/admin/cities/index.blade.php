@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">🏙️ Kelola Kota/Kabupaten</h1>
                    <p class="text-gray-600 mt-2">Tambah atau edit lokasi yang tersedia untuk pengguna</p>
                </div>
                <a href="{{ route('admin.cities.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                    + Tambah Kota
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if ($message = Session::get('success'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-green-800">{{ $message }}</p>
                </div>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p class="text-red-800">{{ $message }}</p>
                </div>
            </div>
        @endif

        <!-- Cities Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            @if ($cities->count() > 0)
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Nama Kota</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Latitude</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Longitude</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Pengguna</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach ($cities as $city)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $city->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $city->latitude }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $city->longitude }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <span class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-full">
                                        {{ $city->users_count }} pengguna
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <a href="{{ route('admin.cities.edit', $city) }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.cities.destroy', $city) }}" method="POST" class="inline-block" onclick="return confirm('Yakin ingin menghapus? Pastikan tidak ada pengguna dari kota ini.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada kota</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat kota baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.cities.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition">
                            + Tambah Kota
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
