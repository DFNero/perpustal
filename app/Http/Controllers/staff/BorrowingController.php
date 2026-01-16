<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Notifications\BorrowingStatusNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // Check if borrowing is still pending
        if ($borrowing->status !== 'pending') {
            return back()->withErrors([
                'error' => 'Pengajuan peminjaman ini sudah diproses sebelumnya.'
            ]);
        }

        try {
            DB::transaction(function () use ($borrowing) {
                // Get current stock
                $pivot = $borrowing->library->books()
                    ->where('books.id', $borrowing->book_id)
                    ->first();

                if (!$pivot) {
                    throw new \Exception('Buku tidak tersedia di perpustakaan ini.');
                }

                $stock = (int) $pivot->pivot->stock;

                if ($stock <= 0) {
                    throw new \Exception('Stok buku habis. Tidak bisa menyetujui peminjaman.');
                }

                // Decrement stock
                $borrowing->book->libraries()
                    ->updateExistingPivot(
                        $borrowing->library_id,
                        ['stock' => DB::raw('stock - 1')]
                    );

                // Update borrowing record with staff info and borrow date
                $borrowing->update([
                    'status' => 'approved',
                    'staff_id' => Auth::id(),
                    'borrow_date' => now()->toDateString(),
                ]);

                // Notify user
                $borrowing->user->notify(
                    new BorrowingStatusNotification('approved', $borrowing->book->title)
                );
            });

            return back()->with('success', 'Peminjaman disetujui dan stok berkurang 1.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function reject(Borrowing $borrowing)
    {
        // Check if borrowing is still pending
        if ($borrowing->status !== 'pending') {
            return back()->withErrors([
                'error' => 'Pengajuan peminjaman ini sudah diproses sebelumnya.'
            ]);
        }

        try {
            DB::transaction(function () use ($borrowing) {
                // Update borrowing record with staff info
                $borrowing->update([
                    'status' => 'rejected',
                    'staff_id' => Auth::id(),
                ]);

                // Notify user
                $borrowing->user->notify(
                    new BorrowingStatusNotification('rejected', $borrowing->book->title)
                );
            });

            return back()->with('success', 'Peminjaman ditolak.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }
}