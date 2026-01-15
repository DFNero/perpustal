{{-- resources\views\admin\libraries\books\index.blade.php --}}

@extends('admin.layout')

@section('title', 'Kelola Buku - ' . $library->name)

@section('content')
    <h2>Kelola Buku di {{ $library->name }}</h2>

    <a href="{{ route('admin.libraries.books.create', $library) }}">+ Tambah Buku</a>
    <a href="{{ route('admin.libraries.index') }}" style="margin-left: 10px;">← Kembali ke Perpustakaan</a>

    @if($library->books->count())
        <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; margin-top:8px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($library->books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->pivot->stock }}</td>
                        <td>
                            <a href="{{ route('admin.libraries.books.edit', [$library, $book]) }}">Edit Stok</a>
                            <form action="{{ route('admin.libraries.books.destroy', [$library, $book]) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus buku dari perpustakaan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color:#c00; background:none; border:none; padding:0; cursor:pointer;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada buku di perpustakaan ini.</p>
    @endif
@endsection