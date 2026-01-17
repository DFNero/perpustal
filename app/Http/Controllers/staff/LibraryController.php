<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Book;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    // List all libraries
    public function index()
    {
        $libraries = Library::withCount('books')->latest()->get();
        return view('staff.libraries.index', compact('libraries'));
    }

    // Show books in a specific library
    public function show(Library $library)
    {
        $books = $library->books()->with('category')->get();
        return view('staff.libraries.show', compact('library', 'books'));
    }

    // Add book to library form
    public function addBookForm(Library $library)
    {
        $availableBooks = Book::whereNotIn('id', $library->books->pluck('id'))
            ->orderBy('title')
            ->get();
        return view('staff.libraries.add-book', compact('library', 'availableBooks'));
    }

    // Store book in library
    public function storeBook(Request $request, Library $library)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id|not_in:' . implode(',', $library->books->pluck('id')->toArray() ?: [0]),
            'stock' => 'required|integer|min:1',
        ]);

        $library->books()->attach($data['book_id'], ['stock' => $data['stock']]);

        return redirect()->route('staff.libraries.show', $library)->with('success', 'Buku berhasil ditambahkan ke perpustakaan.');
    }

    // Edit stock form
    public function editStockForm(Library $library, Book $book)
    {
        $libraryBook = $library->books()->where('book_id', $book->id)->first();
        
        if (!$libraryBook) {
            abort(404);
        }

        return view('staff.libraries.edit-stock', compact('library', 'book', 'libraryBook'));
    }

    // Update stock
    public function updateStock(Request $request, Library $library, Book $book)
    {
        $data = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $library->books()->updateExistingPivot($book->id, ['stock' => $data['stock']]);

        return redirect()->route('staff.libraries.show', $library)->with('success', 'Stok berhasil diperbarui.');
    }

    // Remove book from library
    public function removeBook(Library $library, Book $book)
    {
        $library->books()->detach($book->id);

        return redirect()->route('staff.libraries.show', $library)->with('success', 'Buku berhasil dihapus dari perpustakaan.');
    }
}
