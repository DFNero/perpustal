{{-- resources\views\admin\libraries\books\all.blade.php --}}

@extends('admin.layout')

@section('title', 'Kelola Buku')

@section('content')
    <h2>Kelola Buku per Perpustakaan</h2>

    <p>Pilih perpustakaan untuk mengelola buku-bukunya:</p>

    @if($libraries->count())
        <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; margin-top:8px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Perpustakaan</th>
                    <th>Alamat</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libraries as $lib)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lib->name }}</td>
                        <td>{{ $lib->address }}</td>
                        <td>{{ $lib->books->count() }}</td>
                        <td>
                            <a href="{{ route('admin.libraries.books.index', $lib) }}">Kelola Buku</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada perpustakaan.</p>
    @endif
@endsection
