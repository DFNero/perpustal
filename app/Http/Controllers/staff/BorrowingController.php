<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\ActivityLog;
use App\Notifications\BorrowingStatusNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book', 'library'])
            ->where('status', 'pending')
            ->whereNull('canceled_at')  // Exclude canceled borrowings
            ->latest()
            ->get();

        return view('staff.borrowings.index', compact('borrowings'));
    }

    public function approved()
    {
        $borrowings = Borrowing::with(['user', 'book', 'library'])
            ->where('status', 'approved')
            ->latest()
            ->get();

        return view('staff.borrowings.approved', compact('borrowings'));
    }

    public function approve(Borrowing $borrowing)
    {
        // Validate date inputs
        request()->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date'
        ], [
            'start_date.required' => 'Tanggal mulai harus dipilih.',
            'start_date.date' => 'Tanggal mulai tidak valid.',
            'start_date.after_or_equal' => 'Tanggal mulai tidak boleh sebelum hari ini.',
            'end_date.required' => 'Tanggal pengembalian harus dipilih.',
            'end_date.date' => 'Tanggal pengembalian tidak valid.',
            'end_date.after' => 'Tanggal pengembalian harus setelah tanggal mulai.',
        ]);

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

                // Get dates from request
                $startDate = request()->input('start_date');
                $endDate = request()->input('end_date');

                // Calculate duration in days
                $start = new \DateTime($startDate);
                $end = new \DateTime($endDate);
                $duration = $start->diff($end)->days;

                // Update borrowing record with staff info, borrow date, and due date
                $borrowing->update([
                    'status' => 'approved',
                    'staff_id' => Auth::id(),
                    'borrow_date' => $startDate,
                    'due_date' => $endDate,
                ]);

                // Notify user
                $borrowing->user->notify(
                    new BorrowingStatusNotification('approved', $borrowing->book->title)
                );
            });

            // Log approval activity with dates
            ActivityLog::log(
                Auth::id(),
                'staff_approve_borrow',
                'Borrowing',
                $borrowing->id,
                'Staff approved borrow request for: ' . $borrowing->book->title . ' (User: ' . $borrowing->user->name . ', Start: ' . request()->input('start_date') . ', End: ' . request()->input('end_date') . ')',
                [
                    'book_id' => $borrowing->book_id, 
                    'user_id' => $borrowing->user_id, 
                    'start_date' => request()->input('start_date'),
                    'end_date' => request()->input('end_date')
                ]
            );

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

            // Log rejection activity
            ActivityLog::log(
                Auth::id(),
                'staff_reject_borrow',
                'Borrowing',
                $borrowing->id,
                'Staff rejected borrow request for: ' . $borrowing->book->title . ' (User: ' . $borrowing->user->name . ')',
                ['book_id' => $borrowing->book_id, 'user_id' => $borrowing->user_id]
            );

            return back()->with('success', 'Peminjaman ditolak.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function markAsReturned(Borrowing $borrowing)
    {
        // Validate condition input - only good (aman) and damaged (rusak)
        $rules = [
            'condition' => 'required|in:good,damaged',
        ];
        
        // Only require damage_notes if condition is damaged
        if (request()->input('condition') === 'damaged') {
            $rules['damage_notes'] = 'required|string|min:5|max:500';
        } else {
            $rules['damage_notes'] = 'nullable|string|max:500';
        }
        
        request()->validate($rules, [
            'condition.required' => 'Kondisi buku harus dipilih.',
            'condition.in' => 'Kondisi buku tidak valid. Pilih Aman atau Rusak.',
            'damage_notes.required' => 'Catatan kerusakan wajib diisi jika buku rusak.',
            'damage_notes.min' => 'Catatan kerusakan minimal 5 karakter.',
            'damage_notes.max' => 'Catatan kerusakan maksimal 500 karakter.',
        ]);

        // Check if borrowing is approved
        if ($borrowing->status !== 'approved') {
            return back()->withErrors([
                'error' => 'Hanya peminjaman yang disetujui yang bisa dikembalikan.'
            ]);
        }

        try {
            DB::transaction(function () use ($borrowing) {
                $condition = request()->input('condition');
                $damageNotes = $condition === 'damaged' ? request()->input('damage_notes') : null;

                // Get current stock
                $pivot = $borrowing->library->books()
                    ->where('books.id', $borrowing->book_id)
                    ->first();

                if (!$pivot) {
                    throw new \Exception('Buku tidak tersedia di perpustakaan ini.');
                }

                // Stock handling:
                // - good (aman): Increment stock (return book to library)
                // - damaged (rusak): Decrement stock by 1 (book removed from circulation)
                if ($condition === 'good') {
                    // Return book to library - increment stock
                    $borrowing->book->libraries()
                        ->updateExistingPivot(
                            $borrowing->library_id,
                            ['stock' => DB::raw('stock + 1')]
                        );
                } else {
                    // Damaged book - decrease stock by 1
                    $currentStock = (int) $pivot->pivot->stock;
                    if ($currentStock > 0) {
                        $borrowing->book->libraries()
                            ->updateExistingPivot(
                                $borrowing->library_id,
                                ['stock' => DB::raw('stock - 1')]
                            );
                    }
                }

                // Update borrowing record with return info and condition
                $borrowing->update([
                    'status' => 'returned',
                    'return_date' => now()->toDateString(),
                    'return_condition' => $condition,
                    'damage_notes' => $damageNotes,
                ]);

                // Notify user
                $borrowing->user->notify(
                    new BorrowingStatusNotification('returned', $borrowing->book->title)
                );
            });

            // Log return activity with condition details
            $conditionText = match(request()->input('condition')) {
                'good' => 'Aman',
                'damaged' => 'Rusak',
            };

            ActivityLog::log(
                Auth::id(),
                'staff_process_return',
                'Borrowing',
                $borrowing->id,
                'Staff processed return for: ' . $borrowing->book->title . ' (User: ' . $borrowing->user->name . ', Condition: ' . $conditionText . ')',
                [
                    'book_id' => $borrowing->book_id,
                    'user_id' => $borrowing->user_id,
                    'return_condition' => request()->input('condition'),
                    'damage_notes' => request()->input('damage_notes')
                ]
            );

            $stockMessage = request()->input('condition') === 'damaged' 
                ? 'Buku berhasil dikembalikan dengan kondisi rusak. Stok dikurangi 1.'
                : 'Buku berhasil dikembalikan dengan kondisi aman. Stok bertambah 1.';

            return back()->with('success', $stockMessage);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

}