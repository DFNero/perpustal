{{-- resources/views/admin/libraries/create.blade.php --}}

@extends('admin.layout')

@section('title', 'Tambah Perpustakaan')

@section('content')
    <h2>Tambah Perpustakaan</h2>

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

    <form method="POST" action="{{ route('admin.libraries.store') }}">
        @csrf

        <div>
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Alamat</label><br>
            <textarea name="address" required>{{ old('address') }}</textarea>
            @error('address')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Latitude</label><br>
            <input type="text" name="latitude" value="{{ old('latitude') }}" required>
            @error('latitude')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label>Longitude</label><br>
            <input type="text" name="longitude" value="{{ old('longitude') }}" required>
            @error('longitude')
                <span style="color: #c00;">{{ $message }}</span>
            @enderror
        </div>

        <br>

        <button type="submit">Simpan</button>
        <a href="{{ route('admin.libraries.index') }}">Batal</a>
    </form>
@endsection
