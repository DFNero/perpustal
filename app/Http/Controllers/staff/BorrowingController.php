<?php

namespace App\Http\Controllers\Staff;

use App\Notifications\BorrowingStatusNotification;
use App\Http\Controllers\Controller;
use App\Models\Borrowing;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book', 'library'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('staff.borrowings.index', compact('borrowings'));
    }

    public function approve(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {
    
            $library = $borrowing->library;
            $book = $borrowing->book;
    
            // ambil stok dari pivot
            $pivot = $library->books()
                ->where('book_id', $book->id)
                ->first()
                ->pivot;
    
            if ($pivot->stock <= 0) {
                abort(400, 'Stok buku habis');
            }
    
            // kurangi stok
            $library->books()->updateExistingPivot(
                $book->id,
                ['stock' => $pivot->stock - 1]
            );
    
            // update borrowing
            $borrowing->update([
                'status' => 'approved',
                'staff_id' => auth()->id(),
            ]);

            $borrowing->user->notify(
                new BorrowingStatusNotification($borrowing)
            );

        });
    
        return back()->with('success', 'Peminjaman disetujui & stok dikurangi');
    }


    public function reject(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'rejected',
            'staff_id' => auth()->id(),
        ]);

        $borrowing->user->notify(
            new BorrowingStatusNotification($borrowing)
        );

        return back()->with('success', 'Peminjaman ditolak');
    }
}
