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

        <!-- Nearest Libraries Section (if user is logged in and has libraries in their city) -->
        @if(auth()->check() && count($nearestLibraries) > 0)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">🏛️ Perpustakaan di Kota Anda</h3>
                <p class="text-sm text-gray-600 mb-4">{{ auth()->user()->city->name ?? 'Kota Anda' }} - Perpustakaan terdekat yang memiliki buku ini</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($nearestLibraries as $lib)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $lib['name'] }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">{{ $lib['address'] }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm font-medium">
                                        {{ $lib['distance'] }} km
                                    </div>
                                </div>
                            </div>
                            
                            @if($book->libraries->contains('id', $lib['id']))
                                <div class="text-xs text-green-600 mt-3 flex items-center gap-1">
                                    ✓ Buku tersedia di perpustakaan ini
                                </div>
                            @else
                                <div class="text-xs text-gray-500 mt-3">
                                    Buku mungkin tidak tersedia
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif(auth()->check() && auth()->user()->city_id)
            <div class="bg-yellow-50 rounded-lg shadow p-6 border border-yellow-200">
                <h3 class="text-lg font-semibold text-yellow-900 mb-2">ℹ️ Buku Tidak Tersedia</h3>
                <p class="text-sm text-yellow-800">Buku ini tidak tersedia di perpustakaan manapun di {{ auth()->user()->city->name ?? 'kota Anda' }}.</p>
            </div>
            </div>
        @endif

        <!-- Borrow Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Peminjaman</h3>
            
            @auth
                <form method="POST" action="{{ route('borrow.store', $book) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Perpustakaan di {{ auth()->user()->city->name ?? 'Kota Anda' }}</label>
                        @php
                            // Get only libraries in user's city
                            $userCityLibraries = $book->libraries->filter(fn($lib) => $lib->city_id == auth()->user()->city_id);
                        @endphp
                        <select name="library_id" required class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('library_id') border-red-500 @enderror">
                            <option value="">-- Pilih Perpustakaan --</option>
                            @forelse ($userCityLibraries as $lib)
                                <option value="{{ $lib->id }}">
                                    {{ $lib->name }} (stok: {{ $lib->pivot->stock }})
                                </option>
                            @empty
                                <option value="" disabled>Tidak ada perpustakaan di kota Anda yang memiliki buku ini</option>
                            @endforelse
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

        <!-- Reviews Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">⭐ Rating & Review</h3>
                    @if($book->averageRating() > 0)
                        <div class="flex items-center gap-2 mt-2">
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= round($book->averageRating()))
                                        <span class="text-yellow-400">★</span>
                                    @else
                                        <span class="text-gray-300">★</span>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-sm text-gray-600">{{ round($book->averageRating(), 1) }}/5 ({{ $book->ratingCount() }} rating)</span>
                        </div>
                    @else
                        <p class="text-sm text-gray-600 mt-2">Belum ada rating</p>
                    @endif
                </div>
            </div>

            <!-- Add Review Form -->
            @auth
                <div class="mb-6 pb-6 border-b">
                    <h4 class="text-sm font-medium text-gray-700 mb-4">Berikan Rating & Review</h4>
                    <form method="POST" action="{{ route('reviews.store', $book) }}" class="space-y-4">
                        @csrf

                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" 
                                            {{ auth()->user()->reviews->where('book_id', $book->id)->first()?->rating == $i ? 'checked' : '' }}>
                                        <span class="text-4xl peer-checked:text-yellow-400 text-gray-300 hover:text-yellow-300 transition">★</span>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Komentar (opsional)</label>
                            <textarea name="comment" rows="3" placeholder="Bagikan pengalaman Anda membaca buku ini..." 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ auth()->user()->reviews->where('book_id', $book->id)->first()?->comment ?? '' }}</textarea>
                            @error('comment')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium">
                            Simpan Rating & Review
                        </button>
                    </form>
                </div>
            @else
                <p class="text-gray-600 mb-4 pb-6 border-b">Silakan <a href="{{ route('login') }}" class="text-blue-600 hover:underline">login</a> untuk memberikan rating dan review.</p>
            @endauth

            <!-- Reviews List -->
            <div class="space-y-4">
                @forelse($book->reviews()->latest()->get() as $review)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <p class="font-medium text-gray-900">{{ $review->user->name }}</p>
                                <div class="flex gap-1 mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <span class="text-yellow-400 text-sm">★</span>
                                        @else
                                            <span class="text-gray-300 text-sm">★</span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @auth
                                @if(auth()->user()->id === $review->user_id || auth()->user()->role === 'admin')
                                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="inline" onsubmit="return confirm('Hapus review ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        @if($review->comment)
                            <p class="text-gray-700 text-sm">{{ $review->comment }}</p>
                        @endif
                        <p class="text-xs text-gray-500 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-6">Belum ada review untuk buku ini</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
