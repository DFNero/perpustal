<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ $book->title }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Book Details -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Cover Image -->
                <div class="flex flex-col items-center">
                    @if($book->cover_path)
                        <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="h-64 rounded-lg shadow-lg object-cover">
                    @else
                        <div class="h-64 w-48 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-500 text-4xl">📖</span>
                        </div>
                    @endif
                </div>

                <!-- Book Information -->
                <div class="md:col-span-2 space-y-4">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Penulis</h3>
                        <p class="text-lg text-gray-900">{{ $book->author }}</p>
                    </div>

                    <div>
                        <h3 class="text-sm font-semibold text-gray-600">Penerbit</h3>
                        <p class="text-lg text-gray-900">{{ $book->publisher }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Tahun Terbit</h3>
                            <p class="text-lg text-gray-900">{{ $book->year }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Kategori</h3>
                            <p class="text-lg text-gray-900">{{ $book->category->name ?? '-' }}</p>
                        </div>
                    </div>

                    @if($book->isbn)
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">ISBN</h3>
                            <p class="text-lg text-gray-900">{{ $book->isbn }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            @if($book->description)
                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-sm font-semibold text-gray-600 mb-2">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                </div>
            @endif
        </div>

        <!-- Preview Section -->
        @if($book->preview_path && $previewExists)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">📄 Preview Buku</h3>
                
                @php
                    $extension = pathinfo($book->preview_path, PATHINFO_EXTENSION);
                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif']);
                    $isPDF = $extension === 'pdf';
                    $isText = $extension === 'txt';
                @endphp

                @if($isImage)
                    <!-- Image Preview -->
                    <div class="flex justify-center">
                        <img src="{{ asset('storage/' . $book->preview_path) }}" 
                             alt="Preview" 
                             class="max-w-full max-h-96 rounded-lg shadow">
                    </div>
                @elseif($isPDF)
                    <!-- PDF Preview (iframe) -->
                    <iframe src="{{ asset('storage/' . $book->preview_path) }}" 
                            class="w-full h-96 rounded-lg border border-gray-300"></iframe>
                @elseif($isText && $previewContent)
                    <!-- Text File Content -->
                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-4 max-h-96 overflow-y-auto">
                        <pre class="text-sm text-gray-700 whitespace-pre-wrap break-words font-mono">{{ $previewContent }}</pre>
                    </div>
                @else
                    <!-- File Tidak Bisa Ditampilkan -->
                    <div class="text-center text-gray-500 py-12">
                        <div class="text-5xl mb-2">📄</div>
                        <p class="text-sm">{{ basename($book->preview_path) }}</p>
                        <p class="text-xs text-gray-400 mt-2">Format tidak didukung untuk preview</p>
                    </div>
                @endif
            </div>
        @endif

        <!-- Borrow Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Peminjaman</h3>
            
            @auth
                <form method="POST" action="{{ route('borrow.store', $book) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Perpustakaan</label>
                        <select name="library_id" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Perpustakaan --</option>
                            @foreach ($book->libraries as $lib)
                                <option value="{{ $lib->id }}">
                                    {{ $lib->name }} (stok: {{ $lib->pivot->stock }})
                                </option>
                            @endforeach
                        </select>
                        @error('library_id')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition font-medium w-full">
                        Ajukan Peminjaman
                    </button>
                </form>
            @else
                <p class="text-gray-600 mb-4">Silakan login untuk meminjam buku.</p>
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition font-medium inline-block">
                    Login
                </a>
            @endauth
        </div>
    </div>
</x-app-layout>
