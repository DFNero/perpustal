{{-- resources\views\admin\libraries\books\edit.blade.php --}}

@extends('admin.layout')

@section('title', 'Edit Stok - ' . $book->title)

@section('content')
    <h2>Edit Stok: {{ $book->title }}</h2>
    <p>Perpustakaan: {{ $library->name }}</p>

    @if ($errors->any())
        <div style="color: #c00;">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.libraries.books.update', [$library, $book]) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Stok Saat Ini</label><br>
            <input type="number" name="stock" value="{{ old('stock', $book->pivot?->stock ?? 0) }}" required min="0">
            @error('stock')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <br>
        <button type="submit">Update Stok</button>
        <a href="{{ route('admin.libraries.books.index', $library) }}">Batal</a>
    </form>
@endsection