<!-- Ban User Modal Component -->
<div id="banModal-{{ $user->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" onclick="event.target.id === this.id && closeBanModal({{ $user->id }})">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 animate-fade-in">
        <!-- Header -->
        <div class="border-b px-6 py-4">
            <h2 class="text-xl font-bold text-gray-900">Ban User: {{ $user->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">This action will prevent the user from logging in and accessing the library system</p>
        </div>

        <!-- Body -->
        <div class="px-6 py-6">
            <!-- KTP Display -->
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Collateral Information</h3>
                <x-ktp-card :user="$user" size="md" />
            </div>

            <!-- Ban Reason -->
            <form id="banForm-{{ $user->id }}" action="{{ route('staff.users.ban', $user->id) }}" method="POST" class="space-y-4">
                @csrf
                
                <div>
                    <label for="banReason-{{ $user->id }}" class="block text-sm font-medium text-gray-700 mb-2">
                        Ban Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="banReason-{{ $user->id }}" 
                        name="reason" 
                        rows="4" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                        placeholder="Enter the reason for banning this user...">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmation Message -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-sm text-red-800">
                        <strong>⚠️ Warning:</strong> This will immediately ban <strong>{{ $user->name }}</strong> from the system. The user will not be able to log in or borrow books until this ban is lifted.
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="border-t px-6 py-4 flex justify-end gap-3 bg-gray-50 rounded-b-lg">
            <button 
                type="button" 
                onclick="closeBanModal({{ $user->id }})"
                class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button 
                type="submit" 
                form="banForm-{{ $user->id }}"
                class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors font-medium">
                Confirm Ban
            </button>
        </div>
    </div>
</div>

<script>
function openBanModal(userId) {
    const modal = document.getElementById(`banModal-${userId}`);
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Focus on reason textarea
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

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const visibleModals = document.querySelectorAll('#banModal-* :not(.hidden)');
        visibleModals.forEach(modal => {
            const userId = modal.id.match(/banModal-(\d+)/)?.[1];
            if (userId && !document.getElementById(`banModal-${userId}`).classList.contains('hidden')) {
                closeBanModal(userId);
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
