<!-- Return Condition Form Modal -->
<div id="returnModal-{{ $borrowing->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" onclick="event.target.id === this.id && closeReturnModal({{ $borrowing->id }})">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-fade-in">
        <!-- Header -->
        <div class="border-b px-6 py-4">
            <h2 class="text-xl font-bold text-gray-900">Record Book Return</h2>
            <p class="text-sm text-gray-500 mt-1">Assess the condition of <strong>{{ $borrowing->book->title }}</strong></p>
        </div>

        <!-- Body -->
        <form id="returnForm-{{ $borrowing->id }}" action="{{ route('staff.borrowings.return', $borrowing) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            <!-- Book & User Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-blue-900">
                    <strong>📚 Buku:</strong> {{ $borrowing->book->title }}<br>
                    <strong>👤 Peminjam:</strong> {{ $borrowing->user->name }}<br>
                    <strong>📅 Dipinjam:</strong> {{ $borrowing->borrow_date?->format('d M Y') ?? '-' }}<br>
                    <strong>⏰ Harus Dikembalikan:</strong> {{ $borrowing->due_date?->format('d M Y') ?? '-' }}
                </p>
            </div>

            <!-- Condition Options -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-3">
                    Kondisi Buku <span class="text-red-500">*</span>
                </label>
                <div class="space-y-3">
                    <!-- Good Condition -->
                    <div class="flex items-start">
                        <input 
                            type="radio" 
                            id="condition_good-{{ $borrowing->id }}" 
                            name="condition" 
                            value="good" 
                            required
                            checked
                            class="w-4 h-4 text-green-600 mt-1 cursor-pointer">
                        <label for="condition_good-{{ $borrowing->id }}" class="ml-3 cursor-pointer flex-1">
                            <span class="font-semibold text-gray-900">✅ Baik</span>
                            <span class="text-sm text-gray-500 block">Tidak ada kerusakan, kondisi sempurna</span>
                        </label>
                    </div>

                    <!-- Fair Condition -->
                    <div class="flex items-start">
                        <input 
                            type="radio" 
                            id="condition_fair-{{ $borrowing->id }}" 
                            name="condition" 
                            value="fair" 
                            class="w-4 h-4 text-yellow-600 mt-1 cursor-pointer">
                        <label for="condition_fair-{{ $borrowing->id }}" class="ml-3 cursor-pointer flex-1">
                            <span class="font-semibold text-gray-900">⚠️ Sedang</span>
                            <span class="text-sm text-gray-500 block">Sedikit keausan atau goresan ringan</span>
                        </label>
                    </div>

                    <!-- Damaged Condition -->
                    <div class="flex items-start">
                        <input 
                            type="radio" 
                            id="condition_damaged-{{ $borrowing->id }}" 
                            name="condition" 
                            value="damaged" 
                            class="w-4 h-4 text-red-600 mt-1 cursor-pointer">
                        <label for="condition_damaged-{{ $borrowing->id }}" class="ml-3 cursor-pointer flex-1">
                            <span class="font-semibold text-gray-900">❌ Rusak</span>
                            <span class="text-sm text-gray-500 block">Kerusakan signifikan, tidak dapat diperbaiki</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Damage Notes (conditional) -->
            <div id="damageNotesContainer-{{ $borrowing->id }}" class="hidden">
                <label for="damageNotes-{{ $borrowing->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan Kerusakan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="damageNotes-{{ $borrowing->id }}" 
                    name="damage_notes" 
                    rows="3" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                    placeholder="Jelaskan jenis dan tingkat kerusakan...">{{ old('damage_notes') }}</textarea>
                <p class="text-xs text-gray-500 mt-1">Wajib diisi jika kondisi rusak</p>
            </div>
        </form>

        <!-- Footer -->
        <div class="border-t px-6 py-4 flex justify-end gap-3 bg-gray-50 rounded-b-lg">
            <button 
                type="button" 
                onclick="closeReturnModal({{ $borrowing->id }})"
                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button 
                type="submit" 
                form="returnForm-{{ $borrowing->id }}"
                class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Catat Pengembalian
            </button>
        </div>
    </div>
</div>

<script>
function openReturnModal(borrowingId) {
    const modal = document.getElementById(`returnModal-${borrowingId}`);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setupConditionToggle(borrowingId);
    }
}

function closeReturnModal(borrowingId) {
    const modal = document.getElementById(`returnModal-${borrowingId}`);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function setupConditionToggle(borrowingId) {
    const container = document.getElementById(`damageNotesContainer-${borrowingId}`);
    const textarea = document.getElementById(`damageNotes-${borrowingId}`);
    const radios = document.querySelectorAll(`#returnForm-${borrowingId} input[name="condition"]`);
    
    function updateDamageNotesVisibility() {
        const selectedCondition = document.querySelector(`input[name="condition"][value="damaged"]`).checked;
        if (selectedCondition) {
            container.classList.remove('hidden');
            textarea.required = true;
        } else {
            container.classList.add('hidden');
            textarea.required = false;
            textarea.value = '';
        }
    }
    
    radios.forEach(radio => {
        radio.addEventListener('change', updateDamageNotesVisibility);
    });
    
    // Initial check
    updateDamageNotesVisibility();
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const visibleModals = document.querySelectorAll('[id^="returnModal-"]');
        visibleModals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                const borrowingId = modal.id.match(/returnModal-(\d+)/)?.[1];
                if (borrowingId) {
                    closeReturnModal(borrowingId);
                }
            }
        });
    }
});
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-in {
    animation: fadeIn 0.2s ease-out;
}
</style>
