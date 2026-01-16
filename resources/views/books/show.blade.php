<form method="POST" action="{{ route('borrow.store', $book) }}">
    @csrf

    <label>Perpustakaan</label>
    <select name="library_id" required>
        @foreach ($book->libraries as $lib)
            <option value="{{ $lib->id }}">
                {{ $lib->name }} (stok: {{ $lib->pivot->stock }})
            </option>
        @endforeach
    </select>

    <button type="submit">
        Ajukan Peminjaman
    </button>
</form>
