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

    <form method="post" action="{{ route('profile.update') }}" class="space-y-8">
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
