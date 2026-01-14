@extends('admin.layout')

@section('title', 'Category List')

@section('content')
    <h2>Daftar Kategori</h2>

    <a href="{{ route('admin.categories.create') }}">
        + Tambah Kategori
    </a>

    <ul>
        @forelse ($categories as $category)
            <li class="mb-2">
                {{ $category->name }}
                |
                <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>

                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus kategori ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="color: #c00; background:none; border:none; padding:0; cursor:pointer;">
                        Hapus
                    </button>
                </form>
            </li>
        @empty
            <li>Belum ada kategori</li>
        @endforelse
    </ul>
@endsection
