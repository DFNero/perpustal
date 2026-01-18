<x-guest-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Perpustal Online 📚
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                    Perpustakaan digital sekolah modern dengan sistem peminjaman offline yang inovatif.
                    Akses katalog buku lengkap dan kelola peminjaman dengan mudah.
                </p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('login') }}"
                       class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-300">
                        Masuk ke Akun
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition duration-300">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Fitur Unggulan Perpustal
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Sistem perpustakaan digital yang dirancang untuk memudahkan akses pengetahuan di era modern.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Katalog Buku Lengkap</h3>
                    <p class="text-gray-600">
                        Jelajahi ribuan judul buku dengan sistem pencarian canggih dan kategori yang terorganisir.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl mb-4">🔄</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Peminjaman Offline</h3>
                    <p class="text-gray-600">
                        Sistem peminjaman yang efisien dengan proses offline langsung di perpustakaan sekolah.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Multi-Role System</h3>
                    <p class="text-gray-600">
                        Akses khusus untuk siswa, staf perpustakaan, dan administrator dengan fitur yang sesuai.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl mb-4">📊</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tracking Peminjaman</h3>
                    <p class="text-gray-600">
                        Pantau status peminjaman buku Anda dengan notifikasi real-time dan riwayat lengkap.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl mb-4">🏫</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Berbasis Sekolah</h3>
                    <p class="text-gray-600">
                        Dirancang khusus untuk lingkungan pendidikan dengan fokus pada kemudahan penggunaan.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="text-4xl mb-4">🔒</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Keamanan Data</h3>
                    <p class="text-gray-600">
                        Sistem yang aman dengan enkripsi data dan kontrol akses yang ketat untuk melindungi privasi.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-blue-600 text-white py-16">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">
                Mulai Petualangan Membaca Anda
            </h2>
            <p class="text-xl mb-8">
                Bergabunglah dengan komunitas pembaca sekolah kami dan temukan dunia pengetahuan yang tak terbatas.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('books.index') }}"
                   class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition duration-300">
                    Jelajahi Buku
                </a>
                <a href="{{ route('register') }}"
                   class="px-8 py-4 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition duration-300">
                    Daftar Gratis
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
