<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Show worker activity log (Staff & Admin actions)
     */
    public function workerLog(Request $request)
    {
        $query = ActivityLog::with('user')
            ->whereIn('activity_type', [
                'staff_approve_borrow',
                'staff_reject_borrow',
                'staff_process_return',
                'staff_add_book',
                'staff_update_book',
                'staff_add_book_to_library',
                'staff_update_stock',
                'staff_remove_book_from_library',
                'admin_ban_user',
                'admin_unban_user',
                'admin_delete_category',
                'admin_create_category',
                'admin_manage_staff'
            ])
            ->newest();

        // Filter by staff/admin user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->paginate(25);

        // Get staff and admin users for filter dropdown
        $workers = User::whereIn('role', ['staff', 'admin'])
            ->orderBy('name')
            ->get();

        return view('admin.activity-logs.worker-log', compact('activities', 'workers'));
    }

    /**
     * Show user activity log (User book activities only - no reviews)
     */
    public function userLog(Request $request)
    {
        $query = ActivityLog::with('user')
            ->whereIn('activity_type', [
                'user_borrow',
                'user_cancel_borrow',
                'user_return_request',
            ])
            ->newest();

        // Filter by specific user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by description (book title, etc)
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activities = $query->paginate(25);

        // Get users for filter dropdown
        $users = User::where('role', 'user')
            ->orderBy('name')
            ->get();

        return view('admin.activity-logs.user-log', compact('activities', 'users'));
    }
}
