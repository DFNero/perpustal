<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    /**
     * Show user's activity log (book-related activities only)
     */
    public function activityLog(Request $request)
    {
        $query = ActivityLog::where('user_id', Auth::id())
            ->whereIn('activity_type', [
                'user_borrow',
                'user_cancel_borrow',
                'user_return_request',
            ])
            ->newest();

        // Apply filters if provided
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(25);

        return view('user.activity-log', compact('activities'));
    }

    /**
     * Show user's active and pending borrowings
     */
    public function borrowingsList(Request $request)
    {
        $query = Borrowing::with(['book', 'library', 'staff'])
            ->where('user_id', Auth::id())
            ->active(); // Only show non-canceled

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort by latest first
        $borrowings = $query->latest()->paginate(25);

        return view('user.borrowings-list', compact('borrowings'));
    }

    /**
     * Cancel a pending borrow request
     */
    public function cancelBorrow(Request $request, Borrowing $borrowing)
    {
        // Authorization check
        if ($borrowing->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak dapat membatalkan peminjaman ini.');
        }

        // Can only cancel if status is 'pending' or 'approved'
        if (!in_array($borrowing->status, ['pending', 'approved'])) {
            return back()->with('error', 'Hanya peminjaman dengan status pending atau approved yang dapat dibatalkan.');
        }

        // Can't cancel if already returned
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Peminjaman yang sudah dikembalikan tidak dapat dibatalkan.');
        }

        $reason = $request->validate([
            'cancel_reason' => 'nullable|string|max:500',
        ])['cancel_reason'] ?? 'No reason provided';

        // Soft delete: add canceled_at
        $borrowing->update([
            'canceled_at' => now(),
            'cancel_reason' => $reason,
        ]);

        // Log cancellation activity
        ActivityLog::log(
            Auth::id(),
            'user_cancel_borrow',
            'Borrowing',
            $borrowing->id,
            'User canceled borrow request for: ' . $borrowing->book->title,
            ['reason' => $reason, 'original_status' => $borrowing->status]
        );

        return back()->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }
}
