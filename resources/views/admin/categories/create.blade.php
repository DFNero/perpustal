@extends('admin.layout')

@section('content')
<div class="max-w-md mx-auto">
    <h1 class="text-xl font-bold mb-4">Tambah Category</h1>

    @if ($errors->any())
        <div class="mb-3 text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block mb-1">Nama Category</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border px-3 py-2"
                required
            >
        </div>
        <div class="mb-4">
            <label class="block mb-1">Slug Category</label>
            <input
                type="text"
                name="slug"
                value="{{ old('slug') }}"
                class="w-full border px-3 py-2"
                required
            >
        </div>

        <button class="bg-blue-600 text-white px-4 py-2">
            Simpan
        </button>
    </form>
</div>
@endsection
