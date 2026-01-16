<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'library'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'library_id' => 'required|exists:libraries,id',
        ]);

        // cek stok buku di library (pivot)
        $stock = $book->libraries()
            ->where('library_id', $data['library_id'])
            ->first()
            ?->pivot
            ?->stock ?? 0;

        if ($stock <= 0) {
            return back()->withErrors([
                'stock' => 'Stok buku di perpustakaan ini habis.',
            ]);
        }

        Borrowing::create([
            'user_id'    => Auth::id(),
            'book_id'    => $book->id,
            'library_id' => $data['library_id'],
            'status'     => 'pending',
        ]);

        return redirect()
            ->route('user.borrowings.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}
