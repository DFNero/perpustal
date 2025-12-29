<x-guest-layout>
    <div class="max-w-4xl mx-auto text-center py-20">
        <h1 class="text-4xl font-bold text-blue-600">
            Perpustal Online 📚
        </h1>

        <p class="mt-4 text-gray-600">
            Perpustakaan digital sekolah dengan sistem peminjaman offline.
        </p>

        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('login') }}"
               class="px-6 py-3 bg-blue-600 text-white rounded-lg">
                Login
            </a>

            <a href="{{ route('register') }}"
               class="px-6 py-3 border border-blue-600 text-blue-600 rounded-lg">
                Register
            </a>
        </div>
    </div>
</x-guest-layout>
