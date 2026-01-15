{{-- resources\views\admin\libraries\books\create.blade.php --}}

@extends('admin.layout')

@section('title', 'Tambah Buku - ' . $library->name)

@section('content')
    <h2>Tambah Buku ke {{ $library->name }}</h2>

    @if ($errors->any())
        <div style="color: #c00;">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.libraries.books.store', $library) }}">
        @csrf

        <div>
            <label>Pilih Buku</label><br>
            <select name="book_id" required>
                <option value="">-- Pilih Buku --</option>
                @foreach($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->title }} - {{ $book->author }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Stok</label><br>
            <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0">
        </div>

        <br>
        <button type="submit">Tambah Buku</button>
        <a href="{{ route('admin.libraries.books.index', $library) }}">Batal</a>
    </form>
@endsection