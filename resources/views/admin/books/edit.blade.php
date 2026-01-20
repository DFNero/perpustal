{{-- resources\views\admin\books\edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Edit Buku
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="list-disc ml-5 mt-2">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.books.update', $book) }}" class="space-y-4" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cover Buku (Opsional)</label>
                <div class="flex gap-4 mb-4">
                    <div class="flex-1 space-y-3">
                        <!-- Upload or URL Toggle -->
                        <div x-data="{ mode: 'upload' }" class="space-y-3">
                            <div class="flex gap-4 mb-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="cover_mode" value="upload" x-model="mode" class="mr-2">
                                    <span class="text-sm text-gray-700">Upload File</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="cover_mode" value="url" x-model="mode" class="mr-2">
                                    <span class="text-sm text-gray-700">Paste URL</span>
                                </label>
                            </div>

                            <!-- File Upload -->
                            <div x-show="mode === 'upload'" class="space-y-2">
                                <input type="file" name="cover" accept="image/jpeg,image/png,image/webp" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500">JPG, PNG, atau WebP. Maksimal 2MB</p>
                            </div>

                            <!-- URL Input -->
                            <div x-show="mode === 'url'" class="space-y-2">
                                <input type="url" name="cover_url" placeholder="https://example.com/image.jpg" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500">Paste image URL dari internet. Akan didownload otomatis</p>
                            </div>
                        </div>

                        @error('cover')
                            <span class="text-red-600 text-sm block">{{ $message }}</span>
                        @enderror
                        @error('cover_url')
                            <span class="text-red-600 text-sm block">{{ $message }}</span>
                        @enderror
                    </div>
                    @if($book->cover_path)
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $book->cover_path) }}" alt="{{ $book->title }}" class="h-32 rounded-lg shadow">
                            <p class="text-xs text-gray-500 mt-2">Cover saat ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Preview Buku (Opsional)</label>
                <div class="flex gap-4 mb-4">
                    <div class="flex-1 space-y-3">
                        <!-- Upload or URL Toggle -->
                        <div x-data="{ mode: 'upload' }" class="space-y-3">
                            <div class="flex gap-4 mb-3">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="preview_mode" value="upload" x-model="mode" class="mr-2">
                                    <span class="text-sm text-gray-700">Upload File</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="preview_mode" value="url" x-model="mode" class="mr-2">
                                    <span class="text-sm text-gray-700">Paste URL</span>
                                </label>
                            </div>

                            <!-- File Upload -->
                            <div x-show="mode === 'upload'" class="space-y-2">
                                <input type="file" name="preview" accept=".pdf,image/jpeg,image/png,image/gif,.txt" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500">PDF, JPG, PNG, GIF, atau TXT. Maksimal 5MB</p>
                            </div>

                            <!-- URL Input -->
                            <div x-show="mode === 'url'" class="space-y-2">
                                <input type="url" name="preview_url" placeholder="https://example.com/preview.pdf" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500">Paste file URL dari internet. Akan didownload otomatis</p>
                            </div>
                        </div>

                        @error('preview')
                            <span class="text-red-600 text-sm block">{{ $message }}</span>
                        @enderror
                        @error('preview_url')
                            <span class="text-red-600 text-sm block">{{ $message }}</span>
                        @enderror
                    </div>
                    @if($book->preview_path)
                        <div class="text-center">
                            <div class="text-3xl mb-2">📄</div>
                            <p class="text-xs text-gray-700 font-medium truncate w-24">{{ basename($book->preview_path) }}</p>
                            <p class="text-xs text-gray-500 mt-2">Preview saat ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                <input type="text" name="title" value="{{ old('title', $book->title) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('title')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penulis</label>
                <input type="text" name="author" value="{{ old('author', $book->author) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('author')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Penerbit</label>
                <input type="text" name="publisher" value="{{ old('publisher', $book->publisher) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('publisher')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <input type="number" name="year" value="{{ old('year', $book->year) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required min="1900" max="{{ date('Y') }}">
                    @error('year')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">ISBN (Opsional)</label>
                    <input type="text" name="isbn" value="{{ old('isbn', $book->isbn) }}" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('isbn')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $book->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (Opsional)</label>
                <textarea name="description" class="w-full border border-gray-300 px-3 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 h-24">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium">
                    Update
                </button>
                <a href="{{ route('admin.books.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
