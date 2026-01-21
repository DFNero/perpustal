<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Library;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Total Statistics
        $totalBorrowings = Borrowing::count();
        $pendingBorrowings = Borrowing::where('status', 'pending')->count();
        $approvedBorrowings = Borrowing::where('status', 'approved')->count();
        $returnedBorrowings = Borrowing::where('status', 'returned')->count();
        $totalUsers = User::where('role', 'user')->count();
        $totalBooks = Book::count();
        $totalLibraries = Library::count();

        // Top 5 Most Borrowed Books
        $topBooks = Book::withCount(['borrowings' => function ($query) {
                $query->where('status', '!=', 'rejected');
            }])
            ->orderBy('borrowings_count', 'desc')
            ->take(5)
            ->get();

        // Top 5 Most Active Users
        $topUsers = User::where('role', 'user')
            ->withCount(['borrowings' => function ($query) {
                $query->where('status', '!=', 'rejected');
            }])
            ->orderBy('borrowings_count', 'desc')
            ->take(5)
            ->get();

        // Borrowing Status Breakdown (for chart)
        $borrowingStatus = [
            'pending' => Borrowing::where('status', 'pending')->count(),
            'approved' => Borrowing::where('status', 'approved')->count(),
            'returned' => Borrowing::where('status', 'returned')->count(),
            'rejected' => Borrowing::where('status', 'rejected')->count(),
        ];

        // Recent Activities
        $recentBorrowings = Borrowing::latest()
            ->with(['user', 'book', 'library'])
            ->take(10)
            ->get();

        // Books per Category
        $booksPerCategory = Book::with('category')
            ->select('category_id', DB::raw('count(*) as total'))
            ->groupBy('category_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // Monthly Borrowing Trend (last 6 months)
        $monthlyTrend = Borrowing::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->take(6)
            ->get()
            ->reverse()
            ->values();

        return view('admin.statistics.index', compact(
            'totalBorrowings',
            'pendingBorrowings',
            'approvedBorrowings',
            'returnedBorrowings',
            'totalUsers',
            'totalBooks',
            'totalLibraries',
            'topBooks',
            'topUsers',
            'borrowingStatus',
            'recentBorrowings',
            'booksPerCategory',
            'monthlyTrend'
        ));
    }
}
