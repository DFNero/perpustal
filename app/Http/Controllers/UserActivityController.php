<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{
    /**
     * Show user's activity log (book-related activities + reviews)
     */
    public function activityLog(Request $request)
    {
        $query = ActivityLog::where('user_id', Auth::id())
            ->whereIn('activity_type', [
                'user_borrow',
                'user_cancel_borrow',
                'user_return_request',
                'user_review',
                'user_delete_review',
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
}
