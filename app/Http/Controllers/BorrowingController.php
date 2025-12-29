<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function store(Book $book, Request $request)
    {
        Borrowing::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'library_id' => $request->library_id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Peminjaman berhasil diajukan');
    }
}
