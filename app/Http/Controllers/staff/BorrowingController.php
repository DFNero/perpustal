<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\BorrowingStatusNotification;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::where('status', 'pending')->with(['book','user','library'])->get();
        return view('staff.Borrowings.index', compact('borrowings'));
    }

    public function approve(Borrowing $borrowing)
    {
        // ensure staff only
        $this->authorize('approve', $borrowing); // optional if you setup policies

        DB::transaction(function () use ($borrowing) {
            // refresh relations
            $borrowing->load('book', 'library', 'user');

            // get pivot row for book-library stock
            $pivot = $borrowing->library->books()
                ->where('books.id', $borrowing->book_id)
                ->first();

            if (! $pivot) {
                throw new \Exception('Book not available in selected library.');
            }

            $stock = (int) $pivot->pivot->stock;

            if ($stock <= 0) {
                throw new \Exception('Stock habis. Tidak bisa approve.');
            }

            // decrement stock
            $newStock = $stock - 1;
            $borrowing->library->books()->updateExistingPivot($borrowing->book_id, [
                'stock' => $newStock,
                'updated_at' => now(),
            ]);

            // update borrowing record
            $borrowing->status = 'approved';
            $borrowing->staff_id = auth()->id();
            $borrowing->borrow_date = now()->toDateString();
            $borrowing->save();

            // notify user (database notification)
            $borrowing->user->notify(new BorrowingStatusNotification([
                'borrowing_id' => $borrowing->id,
                'book_title' => $borrowing->book->title,
                'status' => 'approved',
            ]));
        });

        return redirect()->back()->with('success', 'Pengajuan disetujui dan stok dikurangi.');
    }

    public function reject(Borrowing $borrowing)
    {
        $borrowing->status = 'rejected';
        $borrowing->staff_id = auth()->id();
        $borrowing->save();

        $borrowing->user->notify(new BorrowingStatusNotification([
            'borrowing_id' => $borrowing->id,
            'book_title' => $borrowing->book->title,
            'status' => 'rejected',
        ]));

        return redirect()->back()->with('success', 'Pengajuan ditolak.');
    }
}
