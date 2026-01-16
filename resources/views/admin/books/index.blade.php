{{-- resources\views\admin\books\index.blade.php --}}

@extends('admin.layout')

@section('title', 'Kelola Buku')

@section('content')
    <h2>Kelola Buku</h2>

    <a href="{{ route('admin.books.create') }}">+ Tambah Buku</a>

    @if($books->count())
        <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; margin-top:8px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($books as $book)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->publisher }}</td>
                        <td>{{ $book->year }}</td>
                        <td>{{ $book->category->name ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.books.edit', $book) }}">Edit</a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus buku ini?');">
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
        <p>Belum ada buku.</p>
    @endif
@endsection
