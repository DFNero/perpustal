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
        // Get books that are NOT in this library
        $addedBookIds = $library->books()->pluck('book_id')->toArray();
        $books = Book::whereNotIn('id', $addedBookIds)
            ->orderBy('title')
            ->get();
        
        // Calculate stats
        $totalBooks = Book::count();
        $addedCount = count($addedBookIds);
        $remainingCount = $totalBooks - $addedCount;
        
        return view('admin.libraries.books.create', compact('library', 'books', 'addedCount', 'remainingCount', 'totalBooks'));
    }

    public function store(Request $request, Library $library)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'stock'   => 'required|integer|min:0',
        ]);

        // Check if book is already in this library
        $bookExists = $library->books()->where('book_id', $validated['book_id'])->exists();
        
        if ($bookExists) {
            return redirect()->back()
                ->with('error', 'Buku ini sudah ada di perpustakaan. Gunakan "Edit Stock" untuk mengubah jumlah stok.')
                ->withInput();
        }

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
        // Load the book with pivot data
        $book = $library->books()->where('books.id', $book->id)->firstOrFail();
        
        return view('admin.libraries.books.edit', compact('library', 'book'));
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
