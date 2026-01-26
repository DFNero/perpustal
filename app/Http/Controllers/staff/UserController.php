<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Borrowing;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display list of users that can be banned
     */
    public function index()
    {
        // Get all regular users (not staff/admin)
        $users = User::where('role', 'user')
            ->with(['city', 'borrowings' => function($query) {
                $query->whereIn('status', ['pending', 'approved']);
            }])
            ->latest()
            ->get();

        return view('staff.users.index', compact('users'));
    }

    /**
     * Ban a user
     */
    public function ban(User $user)
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

        // Check if already banned
        if ($user->isBanned()) {
            return back()->withErrors([
                'error' => 'User sudah di-ban sebelumnya.'
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
                        $borrowing->update(['status' => 'returned']);
                    }
                }

                // Log the ban action
                ActivityLog::log(
                    Auth::id(),
                    'admin_ban_user',
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
