<!-- Date Range Selector Modal for Borrowing Approval -->
<div id="dateRangeModal-{{ $borrowing->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" onclick="event.target.id === this.id && closeDateRangeModal({{ $borrowing->id }})">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 animate-fade-in">
        <!-- Header -->
        <div class="border-b px-6 py-4">
            <h2 class="text-xl font-bold text-gray-900">Set Tanggal Peminjaman</h2>
            <p class="text-sm text-gray-500 mt-1">Tentukan tanggal mulai dan tanggal pengembalian untuk {{ $borrowing->user->name }}</p>
        </div>

        <!-- Body -->
        <form id="dateRangeForm-{{ $borrowing->id }}" action="{{ route('staff.borrowings.approve', $borrowing) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            <!-- Book Details -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                <p class="text-sm text-blue-900">
                    <strong>📚 Buku:</strong> {{ $borrowing->book->title }}<br>
                    <strong>👤 User:</strong> {{ $borrowing->user->name }}<br>
                    <strong>📍 Perpustakaan:</strong> {{ $borrowing->library->name }}
                </p>
            </div>

            <!-- Date Range Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Start Date -->
                <div>
                    <label for="start_date-{{ $borrowing->id }}" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Mulai <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="start_date-{{ $borrowing->id }}" 
                        name="start_date" 
                        value="{{ old('start_date', now()->format('Y-m-d')) }}"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        onchange="updateEndDateMin({{ $borrowing->id }})"
                    />
                    <p class="text-xs text-gray-500 mt-1">Tanggal mulai peminjaman</p>
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date-{{ $borrowing->id }}" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Pengembalian <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="end_date-{{ $borrowing->id }}" 
                        name="end_date" 
                        value="{{ old('end_date', now()->addDays(7)->format('Y-m-d')) }}"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    />
                    <p class="text-xs text-gray-500 mt-1">Tanggal harus dikembalikan</p>
                </div>
            </div>

            <!-- Duration Preview -->
            <div id="durationPreview-{{ $borrowing->id }}" class="bg-green-50 border border-green-200 rounded-lg p-3 mt-4">
                <p class="text-sm text-green-900">
                    <strong>Durasi:</strong> <span id="durationText-{{ $borrowing->id }}">Menghitung...</span>
                </p>
            </div>

            <!-- Validation Error Display -->
            @error('start_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            @error('end_date')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </form>

        <!-- Footer -->
        <div class="border-t px-6 py-4 flex justify-end gap-3 bg-gray-50 rounded-b-lg">
            <button 
                type="button" 
                onclick="closeDateRangeModal({{ $borrowing->id }})"
                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button 
                type="submit" 
                form="dateRangeForm-{{ $borrowing->id }}"
                class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors font-medium">
                Setujui & Set Tanggal
            </button>
        </div>
    </div>
</div>

<script>
function openDateRangeModal(borrowingId) {
    const modal = document.getElementById(`dateRangeModal-${borrowingId}`);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        updateDurationPreview(borrowingId);
    }
}

function closeDateRangeModal(borrowingId) {
    const modal = document.getElementById(`dateRangeModal-${borrowingId}`);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function updateEndDateMin(borrowingId) {
    const startDate = document.getElementById(`start_date-${borrowingId}`).value;
    const endDateInput = document.getElementById(`end_date-${borrowingId}`);
    
    if (startDate) {
        // Set minimum end date to start date + 1 day
        const minDate = new Date(startDate);
        minDate.setDate(minDate.getDate() + 1);
        endDateInput.min = minDate.toISOString().split('T')[0];
        
        // If current end date is before new min, update it
        if (endDateInput.value < endDateInput.min) {
            endDateInput.value = endDateInput.min;
        }
        
        updateDurationPreview(borrowingId);
    }
}

function updateDurationPreview(borrowingId) {
    const startDateInput = document.getElementById(`start_date-${borrowingId}`);
    const endDateInput = document.getElementById(`end_date-${borrowingId}`);
    const durationText = document.getElementById(`durationText-${borrowingId}`);
    
    if (startDateInput.value && endDateInput.value) {
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);
        
        if (end >= start) {
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays === 1) {
                durationText.textContent = '1 hari';
            } else if (diffDays < 7) {
                durationText.textContent = `${diffDays} hari`;
            } else if (diffDays < 30) {
                const weeks = Math.floor(diffDays / 7);
                const days = diffDays % 7;
                if (days === 0) {
                    durationText.textContent = `${weeks} minggu`;
                } else {
                    durationText.textContent = `${weeks} minggu ${days} hari`;
                }
            } else {
                const months = Math.floor(diffDays / 30);
                const days = diffDays % 30;
                if (days === 0) {
                    durationText.textContent = `${months} bulan`;
                } else {
                    durationText.textContent = `${months} bulan ${days} hari`;
                }
            }
        } else {
            durationText.textContent = 'Tanggal akhir harus setelah tanggal mulai';
            durationText.parentElement.classList.remove('bg-green-50', 'border-green-200');
            durationText.parentElement.classList.add('bg-red-50', 'border-red-200');
            return;
        }
        
        durationText.parentElement.classList.remove('bg-red-50', 'border-red-200');
        durationText.parentElement.classList.add('bg-green-50', 'border-green-200');
    }
}

// Update preview when dates change
document.addEventListener('DOMContentLoaded', function() {
    const borrowingId = {{ $borrowing->id }};
    const startDateInput = document.getElementById(`start_date-${borrowingId}`);
    const endDateInput = document.getElementById(`end_date-${borrowingId}`);
    
    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', () => updateDurationPreview(borrowingId));
        endDateInput.addEventListener('change', () => updateDurationPreview(borrowingId));
    }
});

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const visibleModals = document.querySelectorAll('[id^="dateRangeModal-"]');
        visibleModals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                const borrowingId = modal.id.match(/dateRangeModal-(\d+)/)?.[1];
                if (borrowingId) {
                    closeDateRangeModal(borrowingId);
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
