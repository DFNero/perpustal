<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustal') }} - Perpustakaan Digital Sekolah</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="/" class="flex items-center space-x-2">
                            <x-application-logo class="w-8 h-8 fill-current text-orange-500" />
                            <span class="text-xl font-bold text-gray-900">Perpustal</span>
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#features" class="text-gray-600 hover:text-orange-500 transition-colors">Fitur</a>
                        <a href="#about" class="text-gray-600 hover:text-orange-500 transition-colors">Tentang</a>
                        <a href="{{ route('login') }}" class="text-orange-500 hover:text-orange-600 font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition-colors">Daftar</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center space-x-2 mb-4">
                            <x-application-logo class="w-8 h-8 fill-current text-orange-500" />
                            <span class="text-xl font-bold text-gray-900">Perpustal</span>
                        </div>
                        <p class="text-gray-600 mb-4">
                            Perpustakaan digital sekolah dengan sistem peminjaman offline yang memudahkan akses buku untuk siswa dan staf.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors">
                                <i data-lucide="facebook" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors">
                                <i data-lucide="twitter" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors">
                                <i data-lucide="instagram" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Navigasi</h3>
                        <ul class="space-y-2">
                            <li><a href="#features" class="text-gray-600 hover:text-orange-500 transition-colors">Fitur</a></li>
                            <li><a href="#about" class="text-gray-600 hover:text-orange-500 transition-colors">Tentang</a></li>
                            <li><a href="{{ route('books.index') }}" class="text-gray-600 hover:text-orange-500 transition-colors">Katalog Buku</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Akun</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('login') }}" class="text-gray-600 hover:text-orange-500 transition-colors">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="text-gray-600 hover:text-orange-500 transition-colors">Daftar</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-200 mt-8 pt-8 text-center">
                    <p class="text-gray-600">&copy; 2024 Perpustal. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
