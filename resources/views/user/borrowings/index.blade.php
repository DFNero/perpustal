<x-app-layout>
    <x-slot name="header">
        <x-nav-link href="{{ route('user.borrowings.index') }}" :active="request()->routeIs('user.borrowings.*')"> 
            <h2 class="font-semibold text-xl">
                Riwayat Peminjaman
            </h2>
        </x-nav-link>
    </x-slot>



    <div class="p-6 space-y-4">

        @forelse ($borrowings as $b)
            <div class="border p-4 rounded flex justify-between items-center">

                <div>
                    <p class="font-bold">{{ $b->book->title }}</p>
                    <p class="text-sm text-gray-600">
                        Perpustakaan: {{ $b->library->name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Tanggal: {{ $b->created_at->format('d M Y') }}
                    </p>
                </div>

                {{-- STATUS --}}
                <div>
                    @if ($b->status === 'pending')
                        <span class="px-3 py-1 bg-yellow-400 text-black rounded text-sm">
                            Pending
                        </span>
                    @elseif ($b->status === 'approved')
                        <span class="px-3 py-1 bg-green-600 text-white rounded text-sm">
                            Disetujui
                        </span>
                    @elseif ($b->status === 'rejected')
                        <span class="px-3 py-1 bg-red-600 text-white rounded text-sm">
                            Ditolak
                        </span>
                    @else
                        <span class="px-3 py-1 bg-gray-400 text-white rounded text-sm">
                            Dikembalikan
                        </span>
                    @endif
                </div>

            </div>
        @empty
            <p class="text-gray-500">
                Kamu belum memiliki riwayat peminjaman.
            </p>
        @endforelse

    </div>
</x-app-layout>
