@extends('layouts.guest')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Tentang Perpustal 📚
                </h1>
                <p class="text-xl md:text-2xl max-w-3xl mx-auto">
                    Mengenal lebih dalam tentang sistem perpustakaan digital modern untuk pendidikan
                </p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Mission & Vision -->
        <div class="mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Mission -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">🎯</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Misi Kami</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Memberdayakan generasi muda melalui akses mudah ke pengetahuan. Kami berkomitmen untuk
                        menciptakan ekosistem perpustakaan digital yang inovatif, efisien, dan inklusif bagi seluruh
                        komunitas pendidikan sekolah kami.
                    </p>
                </div>

                <!-- Vision -->
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="text-4xl mb-4">🔮</div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Visi Kami</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Menjadi pionir dalam transformasi perpustakaan tradisional menjadi pusat pembelajaran digital
                        yang dapat diakses kapan saja, di mana saja, dengan fokus pada kemudahan penggunaan dan
                        pengalaman membaca yang menyenangkan.
                    </p>
                </div>
            </div>
        </div>

        <!-- What is Perpustal -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Apa itu Perpustal?</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Perpustal adalah platform perpustakaan digital terintegrasi yang dirancang khusus untuk lingkungan pendidikan sekolah.
                </p>
            </div>

            <div class="bg-white p-8 rounded-lg shadow-md">
                <p class="text-gray-700 leading-relaxed text-lg mb-6">
                    Perpustal adalah website perpustakaan digital sekolah yang menyediakan katalog buku online
                    dengan sistem peminjaman offline langsung ke perpustakaan. Sistem ini menggabungkan kemudahan
                    akses digital dengan proses peminjaman fisik yang terstruktur, memastikan efisiensi dan
                    akuntabilitas dalam pengelolaan koleksi buku sekolah.
                </p>
                <p class="text-gray-700 leading-relaxed text-lg">
                    Dengan Perpustal, siswa dapat menjelajahi katalog buku kapan saja, memesan buku untuk
                    dipinjam, dan melacak status peminjaman mereka. Staf perpustakaan dapat mengelola inventaris
                    dengan mudah, sementara administrator memiliki kontrol penuh atas sistem.
                </p>
            </div>
        </div>

        <!-- Key Features -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Perpustal dilengkapi dengan berbagai fitur canggih untuk memenuhi kebutuhan perpustakaan modern.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-3xl mb-4">🔍</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pencarian Canggih</h3>
                    <p class="text-gray-600">
                        Temukan buku dengan cepat melalui sistem pencarian berdasarkan judul, penulis, kategori, atau ISBN.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-3xl mb-4">📱</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Akses Mobile-Friendly</h3>
                    <p class="text-gray-600">
                        Interface responsif yang dapat diakses dari desktop, tablet, dan smartphone dengan mudah.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-3xl mb-4">🔔</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Notifikasi Real-time</h3>
                    <p class="text-gray-600">
                        Sistem notifikasi otomatis untuk pengingat pengembalian buku dan status peminjaman.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-3xl mb-4">📊</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Dashboard Analytics</h3>
                    <p class="text-gray-600">
                        Laporan dan analitik mendalam untuk monitoring penggunaan dan performa perpustakaan.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-3xl mb-4">🔐</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Sistem Keamanan</h3>
                    <p class="text-gray-600">
                        Enkripsi data dan kontrol akses berbasis role untuk melindungi informasi sensitif.
                    </p>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-3xl mb-4">⚡</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Performa Tinggi</h3>
                    <p class="text-gray-600">
                        Sistem yang dioptimalkan untuk kecepatan dan stabilitas, mendukung pengguna bersamaan.
                    </p>
                </div>
            </div>
        </div>

        <!-- How It Works -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Proses sederhana dari pencarian hingga peminjaman buku di Perpustal.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">1</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Daftar Akun</h3>
                    <p class="text-gray-600">
                        Buat akun pengguna dengan informasi dasar untuk mulai menggunakan sistem.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">2</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Jelajahi Katalog</h3>
                    <p class="text-gray-600">
                        Cari dan temukan buku yang diinginkan dari katalog lengkap kami.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">3</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ajukan Peminjaman</h3>
                    <p class="text-gray-600">
                        Ajukan permintaan peminjaman buku melalui sistem online.
                    </p>
                </div>

                <div class="text-center">
                    <div class="bg-blue-600 text-white w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4">4</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Ambil di Perpustakaan</h3>
                    <p class="text-gray-600">
                        Kunjungi perpustakaan untuk mengambil buku yang telah disetujui.
                    </p>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="bg-white p-8 rounded-lg shadow-md">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
                <p class="text-lg text-gray-600">
                    Butuh bantuan atau memiliki pertanyaan? Jangan ragu untuk menghubungi tim kami.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="text-4xl mb-4">📧</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600">perpustal@school.edu</p>
                </div>

                <div class="text-center">
                    <div class="text-4xl mb-4">📞</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Telepon</h3>
                    <p class="text-gray-600">(021) 123-4567</p>
                </div>

                <div class="text-center">
                    <div class="text-4xl mb-4">📍</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Lokasi</h3>
                    <p class="text-gray-600">Perpustakaan Sekolah<br>Jl. Pendidikan No. 123</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
