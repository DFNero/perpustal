<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class UserBorrowingController extends Controller
{ 
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'library'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.borrowings.index', compact('borrowings'));
    }
}
