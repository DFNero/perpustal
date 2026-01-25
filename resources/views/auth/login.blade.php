{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Login</title>
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

        <!-- LEFT PANEL: 3D Book Stack Visual (Hidden on Mobile) -->
        <div class="hidden lg:flex w-1/2 items-center justify-center p-12 relative bg-gradient-to-br from-orange-50 to-white">
            
            <!-- 3D Book Stack Animation -->
            <div class="relative w-40 h-52 transform-style-3d">
                <!-- Book 1 (Bottom - Red) -->
                <div class="absolute bottom-0 left-4 w-32 h-8 bg-red-400 rounded shadow-lg transform translate-z-8 animate-float" style="animation-delay: 0s;"></div>
                <!-- Book 2 (Middle - Orange) -->
                <div class="absolute bottom-10 left-2 w-32 h-8 bg-orange-500 rounded shadow-lg transform translate-z-16 animate-float" style="animation-delay: 1.5s;"></div>
                <!-- Book 3 (Top - Dark Orange/Red) -->
                <div class="absolute bottom-20 left-0 w-32 h-8 bg-orange-700 rounded shadow-lg transform translate-z-24 animate-float" style="animation-delay: 3s;"></div>
                
                <!-- Decorative Circle -->
                <div class="absolute -z-10 top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 border-4 border-dashed border-orange-200 rounded-full animate-[spin_20s_linear_infinite]"></div>
            </div>

            <div class="relative z-10 ml-16 max-w-sm">
                <h1 class="text-4xl font-bold text-slate-900 mb-4 tracking-tight">Selamat Datang</h1>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Platform Manajemen Perpustakaan Masa Depan. Kelola buku dan anggota dengan mudah.
                </p>
            </div>
        </div>

        <!-- RIGHT PANEL: Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative">
            
            <!-- Glassmorphism Card with 3D Tilt (White Version) -->
            <div id="login-card" class="w-full max-w-md bg-white/80 backdrop-blur-md border border-white/40 rounded-2xl shadow-[0_20px_40px_rgba(0,0,0,0.1)] p-8 transform transition-transform duration-100 ease-out" style="transform-style: preserve-3d;">
                
                <!-- Header -->
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-orange-600 mb-4 shadow-lg shadow-orange-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900">Masuk Akun</h2>
                    <p class="text-slate-500 mt-2">Silakan masukkan kredensial Anda untuk akses.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6 text-green-700 bg-green-50 border border-green-200 rounded-lg p-3 text-center text-sm font-medium" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5" autocomplete="off">
                    @csrf

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
                                autofocus 
                                autocomplete="username" 
                                placeholder="nama@email.com"
                            />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-sm text-red-500" />
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
                                required 
                                autocomplete="current-password" 
                            />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-sm text-red-500" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded" name="remember">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700 select-none">
                            {{ __('Ingat saya di perangkat ini') }}
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                        <a class="text-sm font-medium text-orange-600 hover:text-orange-800 transition-colors w-full sm:w-auto text-center sm:text-left" href="{{ route('register') }}">
                            {{ __('Belum punya akun?') }}
                        </a>
                        
                        <button type="submit" class="w-full sm:w-auto flex justify-center py-2.5 px-6 border border-transparent rounded-xl shadow-lg shadow-orange-200 text-sm font-bold text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transform transition hover:-translate-y-0.5">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom Styles for Animations -->
    <style>
        @keyframes spin {
            from { transform: rotateX(0deg) rotateY(0deg); }
            to { transform: rotateX(360deg) rotateY(360deg); }
        }
        
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px) translateZ(0px); }
            50% { transform: translateY(-10px) translateZ(10px); }
            100% { transform: translateY(0px) translateZ(0px); }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        
        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
        
        /* Helper for 3D transforms */
        .transform-style-3d {
            transform-style: preserve-3d;
        }
    </style>

    <!-- Script for 3D Tilt Effect -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const card = document.getElementById('login-card');
            
            if(card) {
                // Only apply tilt on non-touch devices to avoid mobile weirdness
                if (window.matchMedia("(hover: hover)").matches) {
                    document.addEventListener('mousemove', (e) => {
                        const xAxis = (window.innerWidth / 2 - e.pageX) / 40; // Reduced sensitivity
                        const yAxis = (window.innerHeight / 2 - e.pageY) / 40;
                        
                        // Limit the rotation
                        const clampX = Math.max(-8, Math.min(8, xAxis));
                        const clampY = Math.max(-8, Math.min(8, yAxis));

                        card.style.transform = `rotateY(${clampX}deg) rotateX(${clampY}deg)`;
                    });

                    // Reset when mouse leaves
                    document.addEventListener('mouseleave', () => {
                        card.style.transform = `rotateY(0deg) rotateX(0deg)`;
                        card.style.transition = "transform 0.6s ease";
                    });

                    // Remove transition during movement for instant response
                    document.addEventListener('mouseenter', () => {
                        card.style.transition = "none";
                    });
                }
            }
        });
    </script>
    </body>
</html>