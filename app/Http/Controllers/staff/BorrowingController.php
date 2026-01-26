<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\ActivityLog;
use App\Models\User;
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
        // Validate duration input
        request()->validate([
            'duration' => 'required|in:3,7,14,30'
        ], [
            'duration.required' => 'Durasi peminjaman harus dipilih.',
            'duration.in' => 'Durasi peminjaman tidak valid.',
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

                // Calculate due date based on selected duration
                $duration = (int) request()->input('duration');
                $dueDate = now()->addDays($duration)->toDateString();

                // Update borrowing record with staff info, borrow date, and due date
                $borrowing->update([
                    'status' => 'approved',
                    'staff_id' => Auth::id(),
                    'borrow_date' => now()->toDateString(),
                    'due_date' => $dueDate,
                ]);

                // Notify user
                $borrowing->user->notify(
                    new BorrowingStatusNotification('approved', $borrowing->book->title)
                );
            });

            // Log approval activity with duration
            ActivityLog::log(
                Auth::id(),
                'staff_approve_borrow',
                'Borrowing',
                $borrowing->id,
                'Staff approved borrow request for: ' . $borrowing->book->title . ' (User: ' . $borrowing->user->name . ', Duration: ' . request()->input('duration') . ' days)',
                ['book_id' => $borrowing->book_id, 'user_id' => $borrowing->user_id, 'duration_days' => request()->input('duration')]
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
        // Validate condition input
        request()->validate([
            'condition' => 'required|in:good,fair,damaged',
            'damage_notes' => 'required_if:condition,damaged|string|min:5|max:500'
        ], [
            'condition.required' => 'Kondisi buku harus dipilih.',
            'condition.in' => 'Kondisi buku tidak valid.',
            'damage_notes.required_if' => 'Catatan kerusakan wajib diisi jika buku rusak.',
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

                // Increment stock (only for good and fair condition)
                // For damaged books, stock is NOT incremented (book removed from circulation)
                if ($condition !== 'damaged') {
                    $borrowing->book->libraries()
                        ->updateExistingPivot(
                            $borrowing->library_id,
                            ['stock' => DB::raw('stock + 1')]
                        );
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
                'good' => 'Baik',
                'fair' => 'Sedang',
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
                ? 'Buku berhasil dikembalikan dengan kondisi rusak (tidak ditambahkan kembali ke stok).'
                : 'Buku berhasil dikembalikan dan stok bertambah 1.';

            return back()->with('success', $stockMessage);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => $e->getMessage()
            ]);
        }
    }

    public function banUser(User $user)
    {
        // Validate request
        request()->validate([
            'reason' => 'required|string|min:5|max:500'
        ], [
            'reason.required' => 'Alasan pelarangan harus diisi.',
            'reason.min' => 'Alasan minimal harus 5 karakter.',
            'reason.max' => 'Alasan maksimal 500 karakter.',
        ]);

        // Check if user is staff or admin - staff can only ban regular users
        if ($user->role !== 'user') {
            return back()->withErrors([
                'error' => 'Hanya pengguna biasa yang bisa dilarang.'
            ]);
        }

        try {
            DB::transaction(function () use ($user) {
                $reason = request()->input('reason');
                
                // Ban user permanently
                $user->banUser('permanent', $reason);

                // Check if user has any active borrowings
                $activeBorrowings = Borrowing::where('user_id', $user->id)
                    ->whereIn('status', ['pending', 'approved'])
                    ->get();

                // Reject pending and cancel approved borrowings
                foreach ($activeBorrowings as $borrowing) {
                    if ($borrowing->status === 'pending') {
                        $borrowing->update(['status' => 'rejected']);
                    } elseif ($borrowing->status === 'approved') {
                        // Return stock for approved borrowings
                        $borrowing->book->libraries()
                            ->updateExistingPivot(
                                $borrowing->library_id,
                                ['stock' => DB::raw('stock + 1')]
                            );
                        $borrowing->update(['status' => 'canceled_at']);
                    }
                }

                // Log the ban action
                ActivityLog::log(
                    Auth::id(),
                    'user_banned',
                    'User',
                    $user->id,
                    'Staff banned user: ' . $user->name . ' with KTP: ' . $user->ktp_number,
                    [
                        'user_id' => $user->id,
                        'reason' => $reason,
                        'staff_id' => Auth::id(),
                        'ktp_held' => $user->hasKtpRegistered()
                    ]
                );
            });

            return back()->with('success', $user->name . ' berhasil dilarang dari sistem.');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Gagal melarang pengguna: ' . $e->getMessage()
            ]);
        }
    }
}