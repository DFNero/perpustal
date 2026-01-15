<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryBookController extends Controller
{
    public function allBooks()
    {
        // Show all libraries so admin can choose which one's books to manage
        $libraries = Library::latest()->get();
        return view('admin.libraries.books.all', compact('libraries'));
    }

    public function index(Library $library)
    {
        // eager load books with pivot stock
        $library->load(['books']);
        return view('admin.libraries.books.index', compact('library'));
    }

    public function create(Library $library)
    {
        // list all books to select
        $books = Book::orderBy('title')->get();
        return view('admin.libraries.books.create', compact('library', 'books'));
    }

    public function store(Request $request, Library $library)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'stock'   => 'required|integer|min:0',
        ]);

        // attach or increment stock if already exists
        DB::transaction(function () use ($validated, $library) {
            $bookId = $validated['book_id'];
            $stockToAdd = (int)$validated['stock'];

            $existing = $library->books()->wherePivot('book_id', $bookId)->first();

            if ($existing) {
                // increment pivot stock
                $current = (int) $existing->pivot->stock;
                $library->books()->updateExistingPivot($bookId, [
                    'stock' => $current + $stockToAdd,
                    'updated_at' => now(),
                ]);
            } else {
                $library->books()->attach($bookId, [
                    'stock' => $stockToAdd,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->route('admin.libraries.books.index', $library)
            ->with('success', 'Buku ditambahkan / stock diperbarui.');
    }

    public function edit(Library $library, Book $book)
    {
        // ensure pivot exists
        $pivot = $library->books()->where('books.id', $book->id)->first();
        if (! $pivot) {
            return redirect()->route('admin.libraries.books.index', $library)
                ->with('error', 'Buku tidak ditemukan di perpustakaan ini.');
        }

        $stock = $pivot->pivot->stock;
        return view('admin.libraries.books.edit', compact('library', 'book', 'stock'));
    }

    public function update(Request $request, Library $library, Book $book)
    {
        $data = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($library, $book, $data) {
            $library->books()->updateExistingPivot($book->id, [
                'stock' => (int)$data['stock'],
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('admin.libraries.books.index', $library)
            ->with('success', 'Stock diperbarui.');
    }

    public function destroy(Library $library, Book $book)
    {
        DB::transaction(function () use ($library, $book) {
            $library->books()->detach($book->id);
        });

        return redirect()->route('admin.libraries.books.index', $library)
            ->with('success', 'Buku dihapus dari perpustakaan.');
    }
}
