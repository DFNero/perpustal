<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            Kelola User - Ban User
        </h2>
    </x-slot>

    <div class="p-6 space-y-4">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Daftar User</h3>
                <p class="text-sm text-gray-500 mt-1">Pilih user untuk melakukan ban</p>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-4">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        @if($user->ktp_number)
                                            <p class="text-xs text-gray-500">KTP: {{ $user->ktp_number }}</p>
                                        @endif
                                    </div>
                                    
                                    @if($user->hasKtpRegistered())
                                        <div class="ml-4">
                                            <x-ktp-card :user="$user" size="sm" />
                                        </div>
                                    @endif
                                </div>

                                @if($user->borrowings->count() > 0)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            {{ $user->borrowings->count() }} Peminjaman Aktif
                                        </span>
                                    </div>
                                @endif

                                @if($user->isBanned())
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            🚫 Sudah Di-Ban
                                        </span>
                                        @if($user->banned_reason)
                                            <p class="text-xs text-gray-500 mt-1">Alasan: {{ $user->banned_reason }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            @if(!$user->isBanned())
                                <div class="ml-4">
                                    <button 
                                        type="button" 
                                        onclick="openBanModal({{ $user->id }})"
                                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition-colors">
                                        🚫 Ban User
                                    </button>
                                    <x-ban-modal :user="$user" />
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-gray-500">
                        <p>Tidak ada user yang tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function openBanModal(userId) {
    const modal = document.getElementById(`banModal-${userId}`);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            document.getElementById(`banReason-${userId}`)?.focus();
        }, 100);
    }
}

function closeBanModal(userId) {
    const modal = document.getElementById(`banModal-${userId}`);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const visibleModals = document.querySelectorAll('[id^="banModal-"]');
        visibleModals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                const userId = modal.id.match(/banModal-(\d+)/)?.[1];
                if (userId) {
                    closeBanModal(userId);
                }
            }
        });
    }
});
</script>
