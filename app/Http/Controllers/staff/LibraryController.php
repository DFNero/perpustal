<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\Book;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Get books that are NOT in this library
        $addedBookIds = $library->books()->pluck('book_id')->toArray();
        $availableBooks = Book::whereNotIn('id', $addedBookIds)
            ->orderBy('title')
            ->get();
        
        // Calculate stats
        $totalBooks = Book::count();
        $addedCount = count($addedBookIds);
        $remainingCount = $totalBooks - $addedCount;
        
        return view('staff.libraries.add-book', compact('library', 'availableBooks', 'addedCount', 'remainingCount', 'totalBooks'));
    }

    // Store book in library
    public function storeBook(Request $request, Library $library)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id|not_in:' . implode(',', $library->books->pluck('id')->toArray() ?: [0]),
            'stock' => 'required|integer|min:1',
        ]);

        $library->books()->attach($data['book_id'], ['stock' => $data['stock']]);

        // Log book added to library
        $book = Book::find($data['book_id']);
        ActivityLog::log(
            Auth::id(),
            'staff_add_book_to_library',
            'Book',
            $book->id,
            'Staff added book "' . $book->title . '" to library: ' . $library->name,
            ['library_id' => $library->id, 'stock' => $data['stock']]
        );

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
            'reason' => 'nullable|string|max:500',
        ]);

        $oldStock = $library->books()->where('book_id', $book->id)->first()->pivot->stock;
        $library->books()->updateExistingPivot($book->id, ['stock' => $data['stock']]);

        // Log stock update with reason
        ActivityLog::log(
            Auth::id(),
            'staff_update_stock',
            'Book',
            $book->id,
            'Staff updated stock for "' . $book->title . '" in ' . $library->name . ' from ' . $oldStock . ' to ' . $data['stock'],
            ['library_id' => $library->id, 'old_stock' => $oldStock, 'new_stock' => $data['stock'], 'reason' => $data['reason']]
        );

        return redirect()->route('staff.libraries.show', $library)->with('success', 'Stok berhasil diperbarui.');
    }

    // Remove book from library
    public function removeBook(Library $library, Book $book)
    {
        $library->books()->detach($book->id);

        // Log book removal from library
        ActivityLog::log(
            Auth::id(),
            'staff_remove_book_from_library',
            'Book',
            $book->id,
            'Staff removed book "' . $book->title . '" from library: ' . $library->name,
            ['library_id' => $library->id]
        );

        return redirect()->route('staff.libraries.show', $library)->with('success', 'Buku berhasil dihapus dari perpustakaan.');
    }
}
