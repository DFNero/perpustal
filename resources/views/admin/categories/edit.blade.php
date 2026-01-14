@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
    <h2>Edit Kategori</h2>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Kategori</label><br>
            <input
                type="text"
                name="name"
                value="{{ old('name', $category->name) }}"
                required
            >
        </div>

        <br>

        <button type="submit">
            Update
        </button>
    </form>
@endsection
