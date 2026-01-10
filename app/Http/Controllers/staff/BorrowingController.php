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
        $borrowing->update([
            'status' => 'approved',
        ]);

        // kurangi stok
        $borrowing->library
            ->books()
            ->updateExistingPivot(
                $borrowing->book_id,
                ['stock' => \DB::raw('stock - 1')]
            );

        // kirim notifikasi ke user
        $borrowing->user->notify(
            new BorrowingStatusNotification(
                'approved',
                $borrowing->book->title
            )
        );

        return back()->with('success', 'Peminjaman disetujui');
    }


    public function reject(Borrowing $borrowing)
    {
        $borrowing->update([
            'status' => 'rejected',
        ]);

        $borrowing->user->notify(
            new BorrowingStatusNotification(
                'rejected',
                $borrowing->book->title
            )
        );

        return back()->with('success', 'Peminjaman ditolak');
    }

}
