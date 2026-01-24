<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Book;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['book', 'library'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('borrowings.index', compact('borrowings'));
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->latest()->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markNotificationAsRead($notificationId)
    {
        $notification = Auth::user()->notifications()->find($notificationId);
        
        if ($notification) {
            $notification->markAsRead();
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function store(Request $request, Book $book)
    {
        $data = $request->validate([
            'library_id' => 'required|exists:libraries,id',
        ]);

        // cek stok buku di library (pivot)
        $stock = $book->libraries()
            ->where('library_id', $data['library_id'])
            ->first()
            ?->pivot
            ?->stock ?? 0;

        if ($stock <= 0) {
            return back()->withErrors([
                'stock' => 'Stok buku di perpustakaan ini habis.',
            ]);
        }

        $borrowing = Borrowing::create([
            'user_id'    => Auth::id(),
            'book_id'    => $book->id,
            'library_id' => $data['library_id'],
            'status'     => 'pending',
        ]);

        // Log borrow activity
        ActivityLog::log(
            Auth::id(),
            'user_borrow',
            'Borrowing',
            $borrowing->id,
            'User requested to borrow: ' . $book->title,
            ['library_id' => $data['library_id']]
        );

        return redirect()
            ->route('borrowings.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }
}
