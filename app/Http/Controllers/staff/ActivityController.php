<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Show staff's activity log (only their own activities)
     */
    public function index(Request $request)
    {
        $query = ActivityLog::where('user_id', Auth::id())
            ->whereIn('activity_type', [
                'staff_approve_borrow',
                'staff_reject_borrow',
                'staff_process_return',
                'staff_add_book',
                'staff_update_book',
                'staff_add_book_to_library',
                'staff_update_stock',
                'staff_remove_book_from_library',
            ])
            ->newest();

        // Apply date filters if provided
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply activity type filter
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        $activities = $query->paginate(25);

        return view('staff.activity-log', compact('activities'));
    }
}
