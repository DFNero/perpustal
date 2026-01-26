{{-- resources/views/components/ktp-card.blade.php --}}
{{-- 
    Reusable KTP Display Component
    Props: $user (User model), $showPhoto (bool, default: true), $size (string, default: 'md')
--}}

@props(['user', 'showPhoto' => true, 'size' => 'md'])

@php
    $sizeClasses = [
        'sm' => 'w-32 h-48',
        'md' => 'w-40 h-56',
        'lg' => 'w-48 h-64',
    ];
    
    $containerSize = $sizeClasses[$size] ?? $sizeClasses['md'];
    $photoSize = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col gap-4']) }}>
    
    {{-- KTP Information --}}
    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center gap-2 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0 0h5a2 2 0 002-2V8a2 2 0 00-2-2h-5m0 0V5a2 2 0 012-2h1a2 2 0 012 2v1m0 0h6a2 2 0 012 2v10a2 2 0 01-2 2h-6m0 0v5a2 2 0 01-2 2H9a2 2 0 01-2-2v-5" />
            </svg>
            <h3 class="text-sm font-semibold text-gray-900">Nomor KTP</h3>
        </div>
        
        @if($user->hasKtpRegistered())
            <p class="text-lg font-mono text-gray-700 tracking-wider">
                {{ $user->ktp_number }}
            </p>
            <p class="text-xs text-green-600 mt-2 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
                Sudah terverifikasi
            </p>
        @else
            <p class="text-sm text-gray-500 italic">Belum terdaftar</p>
            <p class="text-xs text-red-600 mt-2">KTP belum dilengkapi</p>
        @endif
    </div>

    {{-- KTP Photo Display --}}
    @if($showPhoto && $user->ktp_photo_path)
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-3 border border-gray-200">
            <p class="text-xs font-semibold text-gray-700 mb-3 uppercase tracking-wider">Foto KTP</p>
            
            <div class="relative group">
                <img 
                    src="{{ $user->ktp_photo_url }}" 
                    alt="Foto KTP {{ $user->name }}" 
                    class="{{ $containerSize }} object-cover rounded-lg border-2 border-gray-300 shadow-md hover:shadow-lg transition-shadow cursor-pointer"
                    onclick="openKtpModal('{{ $user->ktp_photo_url }}', '{{ $user->name }}')"
                />
                
                {{-- Hover Overlay --}}
                <div class="absolute inset-0 rounded-lg bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7" />
                    </svg>
                </div>
            </div>
            
            <p class="text-xs text-gray-500 mt-2">Klik untuk zoom</p>
        </div>
    @elseif($showPhoto)
        <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <p class="text-sm text-gray-500">Foto KTP belum diunggah</p>
        </div>
    @endif

</div>

{{-- Modal for Full-Size KTP Photo --}}
<div id="ktp-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4" onclick="closeKtpModal(event)">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-auto" onclick="event.stopPropagation()">
        <div class="sticky top-0 bg-gray-50 border-b border-gray-200 p-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Foto KTP</h3>
            <button onclick="closeKtpModal()" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <img id="modal-image" src="" alt="Foto KTP" class="w-full h-auto">
    </div>
</div>

<script>
    function openKtpModal(photoUrl, userName) {
        const modal = document.getElementById('ktp-modal');
        const image = document.getElementById('modal-image');
        image.src = photoUrl;
        image.alt = `Foto KTP ${userName}`;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeKtpModal(event) {
        if (event && event.target.id !== 'ktp-modal') return;
        const modal = document.getElementById('ktp-modal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeKtpModal();
    });
</script>
