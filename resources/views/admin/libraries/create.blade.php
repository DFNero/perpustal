{{-- resources/views/admin/libraries/create.blade.php --}}

@extends('admin.layout')

@section('title', 'Tambah Perpustakaan')

@section('content')
    <h2>Tambah Perpustakaan</h2>

    <form method="POST" action="{{ route('admin.libraries.store') }}">
        @csrf

        <div>
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <div>
            <label>Alamat</label><br>
            <textarea name="address">{{ old('address') }}</textarea>
        </div>

        <div>
            <label>Latitude</label><br>
            <input type="text" name="latitude" value="{{ old('latitude') }}">
        </div>

        <div>
            <label>Longitude</label><br>
            <input type="text" name="longitude" value="{{ old('longitude') }}">
        </div>

        <br>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.libraries.index') }}">Batal</a>
    </form>
@endsection
