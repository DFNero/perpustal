{{-- resources\views\admin\books\create.blade.php --}}

@extends('admin.layout')

@section('title', 'Tambah Buku')

@section('content')
    <h2>Tambah Buku</h2>

    @if ($errors->any())
        <div style="color: #c00; border: 1px solid #c00; padding: 10px; margin-bottom: 10px;">
            <strong>Terjadi Kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.books.store') }}">
        @csrf

        <div>
            <label>Judul</label><br>
            <input type="text" name="title" value="{{ old('title') }}" required>
            @error('title')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Penulis</label><br>
            <input type="text" name="author" value="{{ old('author') }}" required>
            @error('author')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Penerbit</label><br>
            <input type="text" name="publisher" value="{{ old('publisher') }}" required>
            @error('publisher')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Tahun</label><br>
            <input type="number" name="year" value="{{ old('year') }}" required min="1900" max="{{ date('Y') }}">
            @error('year')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>ISBN (Opsional)</label><br>
            <input type="text" name="isbn" value="{{ old('isbn') }}">
            @error('isbn')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Kategori</label><br>
            <select name="category_id" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Deskripsi (Opsional)</label><br>
            <textarea name="description">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <br>
        <button type="submit">Simpan</button>
        <a href="{{ route('admin.books.index') }}">Batal</a>
    </form>
@endsection
