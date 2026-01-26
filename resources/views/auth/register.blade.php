{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Register</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 overflow-x-hidden">
    
    <div class="min-h-screen flex overflow-hidden relative">
        
        <!-- BACKGROUND SUBTLE ORBS (Orange Theme) -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
            <div class="absolute -top-[20%] -left-[10%] w-[500px] h-[500px] bg-orange-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-blob"></div>
            <div class="absolute top-[20%] -right-[10%] w-[500px] h-[500px] bg-red-100 rounded-full mix-blend-multiply filter blur-[100px] opacity-70 animate-blob animation-delay-2000"></div>
        </div>

        <!-- LEFT PANEL: Floating ID Cards Visual (Hidden on Mobile) -->
        <div class="hidden lg:flex w-1/2 items-center justify-center p-12 relative bg-gradient-to-br from-orange-50 to-white">
            
            <!-- 3D ID Card Stack Animation -->
            <div class="relative w-48 h-64 transform-style-3d">
                
                <!-- Card Back (Red) -->
                <div class="absolute top-0 left-0 w-32 h-48 bg-red-200 rounded-2xl shadow-lg transform rotate-6 translate-z-8 animate-float-up delay-0"></div>
                
                <!-- Card Middle (Orange) -->
                <div class="absolute top-2 left-4 w-32 h-48 bg-orange-300 rounded-2xl shadow-lg transform -rotate-6 translate-z-16 animate-float-up delay-1000"></div>
                
                <!-- Card Front (White with Icon) -->
                <div class="absolute top-4 left-8 w-32 h-48 bg-white rounded-2xl shadow-xl transform rotate-0 translate-z-24 animate-float-up delay-2000 flex flex-col items-center justify-center text-center p-4">
                    <div class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <div class="h-2 w-20 bg-gray-200 rounded mb-2"></div>
                    <div class="h-2 w-12 bg-gray-100 rounded"></div>
                </div>
                
                <!-- Decorative Circle -->
                <div class="absolute -z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 border-4 border-dashed border-orange-200 rounded-full animate-[spin_20s_linear_infinite]"></div>
            </div>

            <div class="relative z-10 ml-16 max-w-sm">
                <h1 class="text-4xl font-bold text-slate-900 mb-4 tracking-tight">Buat Akun Baru</h1>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Bergabunglah dengan ribuan peminjam buku di seluruh kota. Daftar gratis dalam hitungan detik.
                </p>
            </div>
        </div>

        <!-- RIGHT PANEL: Register Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
            
            <!-- Glassmorphism Card with 3D Tilt (White Version) -->
            <div id="register-card" class="w-full max-w-md bg-white/80 backdrop-blur-md border border-white/40 rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.1)] p-8 transform transition-transform duration-100 ease-out" style="transform-style: preserve-3d;">
                
                <!-- Header -->
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-orange-600 mb-4 shadow-lg shadow-orange-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900">Daftar Akun</h2>
                    <p class="text-slate-500 mt-2">Lengkapi formulir di bawah ini untuk mendaftar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4" autocomplete="off">
                    @csrf

                    <!-- Name -->
                    <div class="group">
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <x-text-input 
                                id="name" 
                                class="block w-full pl-10 bg-white border border-gray-300 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 rounded-xl transition duration-200" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name" 
                                placeholder="John Doe"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <!-- Email Address -->
                    <div class="group">
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <x-text-input 
                                id="email" 
                                class="block w-full pl-10 bg-white border border-gray-300 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 rounded-xl transition duration-200" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username" 
                                placeholder="nama@email.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <!-- Kota/Kabupaten (Styled Select) -->
                    <div class="group">
                        <label for="city" class="block text-sm font-semibold text-slate-700 mb-1">Kota/Kabupaten</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <select id="city" name="city" class="block w-full pl-10 pr-10 py-2.5 bg-white border border-gray-300 text-gray-900 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 shadow-sm transition duration-200 appearance-none" required>
                                <option value="" disabled selected>-- Pilih Kota/Kabupaten --</option>
                                @foreach($cities as $code => $name)
                                    <option value="{{ $code }}" {{ old('city') === $code ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                            <!-- Custom Dropdown Arrow -->
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('city')" class="mt-1.5 text-sm text-red-500" />
                        <p class="text-xs text-gray-500 mt-1 ml-1">Pilih lokasi Anda untuk rekomendasi terdekat</p>
                    </div>

                    <!-- KTP Number (16 Digits) -->
                    <div class="group">
                        <label for="ktp_number" class="block text-sm font-semibold text-slate-700 mb-1">Nomor KTP <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v10a2 2 0 002 2h5m0 0h5a2 2 0 002-2V8a2 2 0 00-2-2h-5m0 0V5a2 2 0 012-2h1a2 2 0 012 2v1m0 0h6a2 2 0 012 2v10a2 2 0 01-2 2h-6m0 0v5a2 2 0 01-2 2H9a2 2 0 01-2-2v-5" />
                                </svg>
                            </div>
                            <x-text-input 
                                id="ktp_number" 
                                class="block w-full pl-10 bg-white border border-gray-300 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 rounded-xl transition duration-200" 
                                type="text" 
                                name="ktp_number" 
                                :value="old('ktp_number')" 
                                required 
                                autocomplete="off" 
                                placeholder="1234567890123456"
                                maxlength="16"
                                inputmode="numeric"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('ktp_number')" class="mt-1.5 text-sm text-red-500" />
                        <p class="text-xs text-gray-500 mt-1 ml-1">Masukkan 16 digit nomor KTP Anda</p>
                    </div>

                    <!-- KTP Photo Upload -->
                    <div class="group">
                        <label for="ktp_photo" class="block text-sm font-semibold text-slate-700 mb-1">Foto KTP <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input 
                                type="file" 
                                id="ktp_photo" 
                                name="ktp_photo" 
                                accept="image/jpeg,image/png,image/jpg,.jpg,.jpeg,.png" 
                                required
                                class="hidden"
                                onchange="updateKtpPreview(this)"
                            />
                            <label for="ktp_photo" class="flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition-colors duration-200 bg-white">
                                <div class="text-center">
                                    <svg class="mx-auto h-8 w-8 text-gray-400 group-focus-within:text-orange-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600"><span class="font-semibold text-orange-600">Klik untuk upload</span> atau drag & drop</p>
                                    <p class="text-xs text-gray-500">JPG, PNG hingga 2MB</p>
                                </div>
                                <span id="ktp-filename" class="hidden ml-2 text-sm text-green-600 font-medium"></span>
                            </label>
                        </div>
                        <!-- KTP Preview -->
                        <div id="ktp-preview-container" class="mt-3 hidden">
                            <img id="ktp-preview" src="" alt="KTP Preview" class="w-full h-32 object-cover rounded-lg border border-gray-300">
                        </div>
                        <x-input-error :messages="$errors->get('ktp_photo')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <!-- Password -->
                    <div class="group">
                        <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <x-text-input 
                                id="password" 
                                class="block w-full pl-10 bg-white border border-gray-300 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 rounded-xl transition duration-200" 
                                type="password" 
                                name="password"
                                required autocomplete="new-password"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="group">
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1">Konfirmasi Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-orange-500 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <x-text-input 
                                id="password_confirmation" 
                                class="block w-full pl-10 bg-white border border-gray-300 text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 rounded-xl transition duration-200" 
                                type="password" 
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password" 
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4">
                        <a class="text-sm font-medium text-orange-600 hover:text-orange-800 transition-colors w-full sm:w-auto text-center sm:text-left" href="{{ route('login') }}">
                            {{ __('Sudah punya akun?') }}
                        </a>
                        
                        <button type="submit" class="w-full sm:w-auto flex justify-center py-2.5 px-6 border border-transparent rounded-xl shadow-lg shadow-orange-200 text-sm font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform transition hover:-translate-y-0.5">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Styles for Animations -->
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        
        @keyframes float-up {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        
        .animate-float-up {
            animation: float-up 4s ease-in-out infinite;
        }
        .delay-0 { animation-delay: 0s; }
        .delay-1000 { animation-delay: 1s; }
        .delay-2000 { animation-delay: 2s; }

        /* Helper for 3D transforms */
        .transform-style-3d {
            transform-style: preserve-3d;
        }
    </style>

    <!-- Script for 3D Tilt Effect -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('register-card');
            
            if(card) {
                // Only apply tilt on non-touch devices
                if (window.matchMedia("(hover: hover)").matches) {
                    document.addEventListener('mousemove', (e) => {
                        const xAxis = (window.innerWidth / 2 - e.pageX) / 40;
                        const yAxis = (window.innerHeight / 2 - e.pageY) / 40;
                        
                        const clampX = Math.max(-8, Math.min(8, xAxis));
                        const clampY = Math.max(-8, Math.min(8, yAxis));

                        card.style.transform = `rotateY(${clampX}deg) rotateX(${clampY}deg)`;
                    });

                    document.addEventListener('mouseleave', () => {
                        card.style.transform = `rotateY(0deg) rotateX(0deg)`;
                        card.style.transition = "transform 0.6s ease";
                    });

                    document.addEventListener('mouseenter', () => {
                        card.style.transition = "none";
                    });
                }
            }
        });
    </script>
    </body>
</html>

<script>
    // KTP Photo Preview
    function updateKtpPreview(input) {
        const previewContainer = document.getElementById('ktp-preview-container');
        const preview = document.getElementById('ktp-preview');
        const filename = document.getElementById('ktp-filename');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                filename.textContent = input.files[0].name;
                filename.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('hidden');
            filename.classList.add('hidden');
        }
    }
</script>