<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    
    public function return(Borrowing $borrowing)
    {
        // Guard: hanya borrowing approved
        if ($borrowing->status !== 'approved') {
            return back()->with('error', 'Borrowing belum approved');
        }
    
        DB::transaction(function () use ($borrowing) {
    
            // update status borrowing
            $borrowing->update([
                'status' => 'returned',
                'return_date' => now(),
            ]);
    
            // tambah stok buku
            DB::table('book_library')
                ->where('book_id', $borrowing->book_id)
                ->where('library_id', $borrowing->library_id)
                ->increment('stock');
        });
    
        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}


