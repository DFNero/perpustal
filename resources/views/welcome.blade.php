<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Welcome</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Scroll Reveal Animation */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease-out;
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Floating Books Animation for Hero */
        @keyframes float-hero {
            0%, 100% { transform: translateY(0px) rotate(-5deg); }
            50% { transform: translateY(-20px) rotate(-5deg); }
        }
        @keyframes float-hero-delay {
            0%, 100% { transform: translateY(0px) rotate(5deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }
        .hero-book-1 { animation: float-hero 6s ease-in-out infinite; }
        .hero-book-2 { animation: float-hero-delay 5s ease-in-out infinite 1s; }
        .hero-book-3 { animation: float-hero 7s ease-in-out infinite 0.5s; }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-white overflow-x-hidden">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        P
                    </div>
                    <span class="font-bold text-2xl tracking-tight text-gray-900">Perpustal<span class="text-orange-600">Online</span></span>
                </div>
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#features" class="text-gray-600 hover:text-orange-600 font-medium transition">Fitur</a>
                    <a href="#about" class="text-gray-600 hover:text-orange-600 font-medium transition">Tentang</a>
                    <a href="#testimonials" class="text-gray-600 hover:text-orange-600 font-medium transition">Kata Mereka</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-orange-600 font-semibold hidden sm:block">Log in</a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 bg-orange-600 text-white font-medium rounded-full hover:bg-orange-700 transition shadow-lg shadow-orange-200 hover:shadow-orange-300 transform hover:-translate-y-0.5">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Decorative Background Blobs (Orange Theme) -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-red-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-orange-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Content -->
                <div class="reveal">
                    <div class="inline-flex items-center px-3 py-1 rounded-full border border-orange-100 bg-orange-50 text-orange-600 text-sm font-semibold mb-6">
                        <span class="flex h-2 w-2 relative mr-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-orange-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-orange-500"></span>
                        </span>
                        Platform Perpustakaan #1 di Sekolah
                    </div>
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-gray-900 tracking-tight leading-tight mb-6">
                        Jendela Dunia <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-red-600">Dalam Genggaman.</span>
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed max-w-xl">
                        Perpustal Online menghadirkan pengalaman perpustakaan modern yang menggabungkan kekuatan teknologi digital dengan kehangatan literasi fisik. Kelola, jelajah, dan pinjam buku dengan cara yang belum pernah ada sebelumnya.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-8 py-4 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition duration-300 shadow-xl shadow-orange-200 hover:shadow-orange-300 transform hover:-translate-y-1">
                            Mulai Petualangan
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Right: 3D Visual Composition -->
                <div class="relative h-[500px] w-full flex items-center justify-center reveal">
                    <!-- Decorative Circle -->
                    <div class="absolute w-64 h-64 border-4 border-dashed border-orange-200 rounded-full animate-[spin_20s_linear_infinite]"></div>
                    
                    <!-- Book Stacks -->
                    <div class="relative z-10 w-64 h-80">
                        <!-- Back Book (Red) -->
                        <div class="absolute top-0 right-0 w-40 h-56 bg-gradient-to-br from-red-200 to-red-300 rounded-lg shadow-2xl hero-book-2 transform -rotate-12 border-l-8 border-red-400"></div>
                        <!-- Middle Book (Orange) -->
                        <div class="absolute top-10 left-10 w-40 h-56 bg-gradient-to-br from-orange-200 to-orange-300 rounded-lg shadow-2xl hero-book-1 transform rotate-6 border-l-8 border-orange-400"></div>
                        <!-- Front Book (White Card) -->
                        <div class="absolute top-20 left-20 w-40 h-56 bg-white rounded-lg shadow-2xl hero-book-3 transform rotate-0 p-6 flex flex-col justify-between border border-gray-100">
                            <div>
                                <div class="w-10 h-10 bg-orange-50 rounded-full mb-4 flex items-center justify-center text-orange-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-800 text-lg leading-tight">Modern Library System</h4>
                                <p class="text-xs text-gray-500 mt-1">Digital & Hybrid</p>
                            </div>
                            <div class="space-y-2">
                                <div class="h-2 w-full bg-gray-100 rounded"></div>
                                <div class="h-2 w-2/3 bg-gray-100 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deep Content / About Section -->
    <div class="py-24 bg-gray-50" id="about">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Mengapa Perpustal Online?</h2>
                <p class="text-lg text-gray-600">
                    Kami percaya bahwa perpustakaan bukan sekadar tempat menyimpan buku, melainkan jantung dari ekosistem belajar di sekolah. Platform ini dibangun untuk menjembatani kesenjangan antara kebiasaan tradisional dan inovasi digital.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center mb-20">
                <div class="order-2 md:order-1 reveal">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Mendigitalkan Pengalaman Fisik</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Lupakan kartu peminjaman kertas yang mudah hilang. Dengan Perpustal, setiap aktivitas peminjaman di perpustakaan fisik tercatat secara real-time dalam sistem digital. Siswa dapat mengecek ketersediaan buku dari kelas mereka tanpa perlu jalan ke rak buku, menghemat waktu berharga mereka untuk belajar.
                    </p>
                    <ul class="space-y-3">
                        <li class="flex items-start text-gray-700">
                            <svg class="h-6 w-6 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Pencarian buku instan via smartphone.
                        </li>
                        <li class="flex items-start text-gray-700">
                            <svg class="h-6 w-6 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Notifikasi otomatis saat jatuh tempo.
                        </li>
                        <li class="flex items-start text-gray-700">
                            <svg class="h-6 w-6 text-orange-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Riwayat bacaan yang terdokumentasi.
                        </li>
                    </ul>
                </div>
                <div class="order-1 md:order-2 bg-white p-6 rounded-2xl shadow-xl reveal">
                    <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Library Shelf" class="rounded-xl shadow-sm">
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="reveal">
                    <div class="bg-white p-6 rounded-2xl shadow-xl">
                        <img src="https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Student Reading" class="rounded-xl shadow-sm">
                    </div>
                </div>
                <div class="reveal">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Membangun Budaya Literasi</h3>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Platform ini tidak hanya untuk meminjam buku, tapi juga untuk menemukan buku. Sistem rekomendasi cerdas kami membantu siswa menemukan bacaan baru berdasarkan minat mereka, sejarah peminjaman, dan tren literasi terkini di sekolah.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Bagi staf perpustakaan, kami menyediakan dashboard analitik yang memudahkan manajemen inventaris, laporan denda, dan peramalan stok. Semua dalam satu antarmuka yang indah dan mudah digunakan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div class="py-24 bg-white" id="features">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Didesain dengan cermat untuk memenuhi kebutuhan administrasi perpustakaan modern.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 (Orange) -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group reveal">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-6 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pencarian Instan</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Temukan buku dalam hitungan detik. Sistem pencarian kami mengindeks judul, penulis, ISBN, dan bahkan deskripsi isi buku.
                    </p>
                </div>

                <!-- Feature 2 (Red) -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group reveal">
                    <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center text-red-600 mb-6 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Manajemen User</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem multi-role yang memisahkan hak akses member, staff dan admin. Setiap orang mendapatkan pengalaman yang sesuai dengan kebutuhan mereka.
                    </p>
                </div>

                <!-- Feature 3 (Amber) -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group reveal">
                    <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mb-6 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Statistik</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dashboard analitik mendalam untuk melihat buku terpopuler, durasi peminjaman, dan aktivitas pengguna bulanan.
                    </p>
                </div>

                <!-- Feature 4 (Orange) -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group reveal">
                    <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-600 mb-6 group-hover:bg-orange-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Booking Koleksi</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Siswa dapat memesan buku yang sedang dipinjam orang lain. Mereka akan mendapat notifikasi otomatis saat buku kembali.
                    </p>
                </div>

                <!-- Feature 5 (Red) -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group reveal">
                    <div class="w-14 h-14 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 mb-6 group-hover:bg-red-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pengingat Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Tidak perlu khawatir denda. Sistem mengirim pengingat Email/SMS satu hari sebelum tanggal pengembalian.
                    </p>
                </div>

                <!-- Feature 6 (Amber) -->
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group reveal">
                    <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 mb-6 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Keamanan Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Data pribadi dan riwayat bacaan siswa dienkripsi dan dilindungi dengan standar keamanan tinggi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="py-20 bg-gray-50" id="testimonials">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12 reveal">Kata Mereka</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Quote 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-md reveal">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-600 italic mb-6">"Perpustal Online mengubah cara saya mencari referensi untuk tugas. Saya tidak perlu lagi bingung mencari buku yang berserakan di rak."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center font-bold text-orange-600">A</div>
                        <div class="ml-3">
                            <div class="font-bold text-gray-900">cak fuu</div>
                            <div class="text-xs text-gray-500">Siswa Kelas 20</div>
                        </div>
                    </div>
                </div>
                <!-- Quote 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-md reveal">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-600 italic mb-6">"Sebagai Kepala Sekolah, saya bisa melihat statistik literasi siswa secara real-time. Ini sangat membantu dalam mengambil keputusan kurikulum."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center font-bold text-red-600">S</div>
                        <div class="ml-3">
                            <div class="font-bold text-gray-900">Siti Aminah</div>
                            <div class="text-xs text-gray-500">Kepala Perpustakaan</div>
                        </div>
                    </div>
                </div>
                <!-- Quote 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-md reveal">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 text-lg">★★★★★</div>
                    </div>
                    <p class="text-gray-600 italic mb-6">"Sistemnya sangat ringan dan mudah digunakan di HP. Peminjaman sekarang feels seperti belanja di e-commerce, tapi untuk buku."</p>
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center font-bold text-amber-600">R</div>
                        <div class="ml-3">
                            <div class="font-bold text-gray-900">Fairuz gemink gk belajar</div>
                            <div class="text-xs text-gray-500">Siswa Kelas 1</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA -->
    <div class="relative py-20 bg-orange-600 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-700 to-red-700"></div>
            <!-- Decorative shapes -->
            <svg class="absolute right-0 top-0 h-full w-64 text-orange-500 opacity-10" fill="currentColor" viewBox="0 0 100 100"><path d="M0 0h100v100H0z"/></svg>
            <svg class="absolute left-0 bottom-0 h-full w-64 text-red-500 opacity-10" fill="currentColor" viewBox="0 0 100 100"><path d="M0 0h100v100H0z"/></svg>
        </div>

        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-bold text-white mb-6">Siap Membangun Masa Depan Literasi?</h2>
            <p class="text-xl text-orange-100 mb-10 max-w-2xl mx-auto">
                Bergabunglah dengan ribuan siswa dan staf lainnya yang telah mengalami kemudahan manajemen perpustakaan modern. Daftar gratis hari ini.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-10 py-4 bg-white text-orange-600 font-bold text-lg rounded-xl hover:bg-gray-100 transition duration-300 shadow-lg transform hover:-translate-y-1">
                    Daftar Gratis Sekarang
                </a>
                <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-10 py-4 bg-transparent text-white font-bold text-lg rounded-xl border-2 border-white hover:bg-white hover:text-orange-600 transition duration-300">
                    Saya Sudah Punya Akun
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-orange-600 rounded flex items-center justify-center font-bold">P</div>
                    <span class="font-bold text-xl">Perpustal Online</span>
                </div>
                <p class="text-gray-400 text-sm max-w-xs">
                    Platform manajemen perpustakaan sekolah terintegrasi yang menghubungkan siswa dengan pengetahuan melalui teknologi.
                </p>
            </div>
            <div>
                <h4 class="font-bold mb-4">Menu</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li><a href="{{ route('login') }}" class="hover:text-white">Login</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white">Register</a></li>
                    <li><a href="#" class="hover:text-white">Katalog Buku</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-4">Hubungi Kami</h4>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>support@perpustal.id</li>
                    <li>Jakarta, Indonesia</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-8 border-t border-gray-800 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Perpustal Online. All rights reserved.
        </div>
    </footer>

    <!-- Script for Navbar & Scroll Animations -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 20) {
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('shadow-md');
            }
        });

        // Scroll Reveal Animation (Intersection Observer)
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.reveal');

            const revealOnScroll = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        // Optional: stop observing once revealed
                        // observer.unobserve(entry.target);
                    }
                });
            }, {
                root: null,
                threshold: 0.1, // Trigger when 10% of element is visible
                rootMargin: "0px"
            });

            reveals.forEach(el => revealOnScroll.observe(el));
        });
    </script>
</body>
</html>