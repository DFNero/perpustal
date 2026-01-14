{{-- resources\views\admin\libraries\index.blade.php --}}

@extends('admin.layout')

@section('title', 'Perpustakaan')

@section('content')
    <h2>Daftar Perpustakaan</h2>

    <a href="{{ route('admin.libraries.create') }}">+ Tambah Perpustakaan</a>

    @if($libraries->count())
        <table border="1" cellpadding="6" cellspacing="0" style="border-collapse:collapse; margin-top:8px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Koordinat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($libraries as $lib)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $lib->name }}</td>
                        <td>{{ $lib->address }}</td>
                        <td>{{ $lib->latitude }}, {{ $lib->longitude }}</td>
                        <td>
                            <a href="{{ route('admin.libraries.edit', $lib) }}">Edit</a>
                            <form action="{{ route('admin.libraries.destroy', $lib) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus perpustakaan ini?');">
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
        <p>Belum ada perpustakaan.</p>
    @endif
@endsection
