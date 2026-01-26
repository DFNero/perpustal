<!-- Duration Selector Modal for Borrowing Approval -->
<div id="durationModal-{{ $borrowing->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" onclick="event.target.id === this.id && closeDurationModal({{ $borrowing->id }})">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 animate-fade-in">
        <!-- Header -->
        <div class="border-b px-6 py-4">
            <h2 class="text-xl font-bold text-gray-900">Select Borrowing Duration</h2>
            <p class="text-sm text-gray-500 mt-1">How long will {{ $borrowing->user->name }} borrow <strong>{{ $borrowing->book->title }}</strong>?</p>
        </div>

        <!-- Body -->
        <form id="durationForm-{{ $borrowing->id }}" action="{{ route('staff.borrowings.approve', $borrowing) }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            <!-- Duration Options -->
            <div class="space-y-3">
                <div class="flex items-center">
                    <input 
                        type="radio" 
                        id="duration3-{{ $borrowing->id }}" 
                        name="duration" 
                        value="3" 
                        required
                        class="w-4 h-4 text-blue-600 cursor-pointer">
                    <label for="duration3-{{ $borrowing->id }}" class="ml-3 cursor-pointer flex-1">
                        <span class="font-semibold text-gray-900">3 Days</span>
                        <span class="text-sm text-gray-500 block">Due: {{ now()->addDays(3)->format('d M Y') }}</span>
                    </label>
                </div>

                <div class="flex items-center">
                    <input 
                        type="radio" 
                        id="duration7-{{ $borrowing->id }}" 
                        name="duration" 
                        value="7" 
                        checked
                        class="w-4 h-4 text-blue-600 cursor-pointer">
                    <label for="duration7-{{ $borrowing->id }}" class="ml-3 cursor-pointer flex-1">
                        <span class="font-semibold text-gray-900">7 Days (1 Week)</span>
                        <span class="text-sm text-gray-500 block">Due: {{ now()->addDays(7)->format('d M Y') }}</span>
                    </label>
                </div>

                <div class="flex items-center">
                    <input 
                        type="radio" 
                        id="duration14-{{ $borrowing->id }}" 
                        name="duration" 
                        value="14" 
                        class="w-4 h-4 text-blue-600 cursor-pointer">
                    <label for="duration14-{{ $borrowing->id }}" class="ml-3 cursor-pointer flex-1">
                        <span class="font-semibold text-gray-900">14 Days (2 Weeks)</span>
                        <span class="text-sm text-gray-500 block">Due: {{ now()->addDays(14)->format('d M Y') }}</span>
                    </label>
                </div>

                <div class="flex items-center">
                    <input 
                        type="radio" 
                        id="duration30-{{ $borrowing->id }}" 
                        name="duration" 
                        value="30" 
                        class="w-4 h-4 text-blue-600 cursor-pointer">
                    <label for="duration30-{{ $borrowing->id }}" class="ml-3 cursor-pointer flex-1">
                        <span class="font-semibold text-gray-900">30 Days (1 Month)</span>
                        <span class="text-sm text-gray-500 block">Due: {{ now()->addDays(30)->format('d M Y') }}</span>
                    </label>
                </div>
            </div>

            <!-- Book Details -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mt-4">
                <p class="text-sm text-blue-900">
                    <strong>📚 Book:</strong> {{ $borrowing->book->title }}<br>
                    <strong>👤 User:</strong> {{ $borrowing->user->name }}<br>
                    <strong>📍 Library:</strong> {{ $borrowing->library->name }}
                </p>
            </div>
        </form>

        <!-- Footer -->
        <div class="border-t px-6 py-4 flex justify-end gap-3 bg-gray-50 rounded-b-lg">
            <button 
                type="button" 
                onclick="closeDurationModal({{ $borrowing->id }})"
                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button 
                type="submit" 
                form="durationForm-{{ $borrowing->id }}"
                class="px-4 py-2 text-white bg-green-600 rounded-lg hover:bg-green-700 transition-colors font-medium">
                Approve & Set Duration
            </button>
        </div>
    </div>
</div>

<script>
function openDurationModal(borrowingId) {
    const modal = document.getElementById(`durationModal-${borrowingId}`);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeDurationModal(borrowingId) {
    const modal = document.getElementById(`durationModal-${borrowingId}`);
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const visibleModals = document.querySelectorAll('[id^="durationModal-"]');
        visibleModals.forEach(modal => {
            if (!modal.classList.contains('hidden')) {
                const borrowingId = modal.id.match(/durationModal-(\d+)/)?.[1];
                if (borrowingId) {
                    closeDurationModal(borrowingId);
                }
            }
        });
    }
});

// Update due date display when duration changes
document.querySelectorAll('input[type="radio"][name="duration"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const label = this.nextElementSibling;
        if (label) {
            console.log('Duration selected: ' + this.value + ' days');
        }
    });
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
