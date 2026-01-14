{{-- resources\views\admin\libraries\edit.blade.php --}}

@extends('admin.layout')

@section('title', 'Edit Perpustakaan')

@section('content')
    <h2>Edit Perpustakaan</h2>

    @if ($errors->any())
        <div style="color: #c00;">
            <ul>
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.libraries.update', $library) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name', $library->name) }}" required>
        </div>
        <div>
            <label>Alamat</label><br>
            <textarea name="address" required>{{ old('address', $library->address) }}</textarea>
        </div>
        <div>
            <label>Latitude</label><br>
            <input type="text" name="latitude" value="{{ old('latitude', $library->latitude) }}" required>
        </div>
        <div>
            <label>Longitude</label><br>
            <input type="text" name="longitude" value="{{ old('longitude', $library->longitude) }}" required>
        </div>

        <br>
        <button type="submit">Update</button>
    </form>
@endsection
