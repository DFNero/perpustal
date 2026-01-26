<section>
    <header class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xl font-bold">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Profil Saya</h2>
                <p class="text-sm text-gray-600 mt-1">Kelola informasi akun Anda</p>
            </div>
        </div>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Name Section -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">👤</span> Nama Lengkap
            </label>
            <input 
                id="name" 
                name="name" 
                type="text" 
                class="w-full px-4 py-3 rounded-lg border-2 border-blue-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all text-gray-900 placeholder-gray-400" 
                value="{{ old('name', $user->name) }}" 
                required 
                autofocus 
                autocomplete="name"
                placeholder="Masukkan nama lengkap Anda"
            />
            @error('name')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Location/City Section -->
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-6 border border-orange-200">
            <label for="city_id" class="block text-sm font-bold text-gray-700 mb-2 flex items-center gap-2">
                <span class="text-lg">📍</span> Kota/Kabupaten
            </label>
            <select 
                id="city_id" 
                name="city_id" 
                class="w-full px-4 py-3 rounded-lg border-2 border-orange-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all text-gray-900"
                required
            >
                <option value="">-- Pilih Kota/Kabupaten --</option>
                @foreach ($cities as $city)
                    <option value="{{ $city->id }}" {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('city_id')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-gray-600">Pilih lokasi terdekat dengan tempat tinggal Anda untuk menemukan perpustakaan terdekat</p>
        </div>

        <!-- Current City Info -->
        @if ($user->city)
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                <p class="text-sm text-gray-700">
                    <span class="font-semibold">Lokasi Saat Ini:</span> 
                    <span class="text-green-700 font-medium">{{ $user->city->name }}</span>
                </p>
            </div>
        @endif

        <!-- KTP Information Section -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center gap-2 mb-4">
                <span class="text-lg">🆔</span>
                <h3 class="text-lg font-bold text-gray-900">Informasi KTP</h3>
                @if($user->hasKtpRegistered())
                    <span class="ml-auto px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">✓ Terverifikasi</span>
                @else
                    <span class="ml-auto px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">⚠ Belum Lengkap</span>
                @endif
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- KTP Display Component -->
                <div>
                    <x-ktp-card :user="$user" size="md" />
                </div>

                <!-- KTP Update Form -->
                <div class="space-y-4">
                    <p class="text-sm text-gray-700 font-semibold mb-3">Update Data KTP</p>
                    
                    <!-- KTP Number -->
                    <div>
                        <label for="ktp_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor KTP (16 Digit)</label>
                        <input 
                            id="ktp_number" 
                            name="ktp_number" 
                            type="text" 
                            maxlength="16"
                            inputmode="numeric"
                            class="w-full px-4 py-2 rounded-lg border-2 border-purple-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all text-gray-900 placeholder-gray-400 font-mono" 
                            value="{{ old('ktp_number', $user->ktp_number) }}" 
                            autocomplete="off"
                            placeholder="1234567890123456"
                        />
                        @error('ktp_number')
                            <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Hanya angka, 16 digit</p>
                    </div>

                    <!-- KTP Photo Upload -->
                    <div>
                        <label for="ktp_photo" class="block text-sm font-medium text-gray-700 mb-2">Foto KTP (JPG/PNG Max 2MB)</label>
                        <div class="relative">
                            <input 
                                type="file" 
                                id="ktp_photo" 
                                name="ktp_photo" 
                                accept="image/jpeg,image/png,image/jpg" 
                                class="hidden"
                                onchange="updateProfileKtpPreview(this)"
                            />
                            <label for="ktp_photo" class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-purple-300 rounded-lg cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition-colors bg-white">
                                <div class="text-center">
                                    <svg class="mx-auto h-6 w-6 text-purple-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="mt-1 text-xs text-gray-600"><span class="font-semibold text-purple-600">Klik</span> untuk ganti foto</p>
                                </div>
                            </label>
                        </div>
                        @error('ktp_photo')
                            <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                        <p id="ktp-filename" class="text-xs text-green-600 mt-2 font-medium hidden"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <button 
                type="submit"
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all shadow-md hover:shadow-lg"
            >
                💾 Simpan Perubahan
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm font-medium text-green-600 flex items-center gap-2"
                >
                    ✅ Profil berhasil diperbarui
                </p>
            @endif
        </div>
    </form>
</section>

<script>
    // KTP Photo Preview in Profile
    function updateProfileKtpPreview(input) {
        const filename = document.getElementById('ktp-filename');
        
        if (input.files && input.files[0]) {
            filename.textContent = `✓ File dipilih: ${input.files[0].name}`;
            filename.classList.remove('hidden');
        } else {
            filename.classList.add('hidden');
        }
    }
</script>
