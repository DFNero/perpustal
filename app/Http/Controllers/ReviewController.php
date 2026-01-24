<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        // Check if user already reviewed this book
        $existingReview = Review::where('book_id', $book->id)
            ->where('user_id', auth()->id())
            ->first();

        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $validated['book_id'] = $book->id;
        $validated['user_id'] = auth()->id();

        if ($existingReview) {
            $existingReview->update($validated);
            
            // Log update activity
            ActivityLog::log(
                auth()->id(),
                'user_review',
                'Review',
                $existingReview->id,
                'User updated review for book: ' . $book->title,
                ['rating' => $validated['rating']]
            );
            
            return back()->with('success', 'Rating dan review diperbarui.');
        } else {
            $newReview = Review::create($validated);
            
            // Log creation activity
            ActivityLog::log(
                auth()->id(),
                'user_review',
                'Review',
                $newReview->id,
                'User created review for book: ' . $book->title,
                ['rating' => $validated['rating']]
            );
            
            return back()->with('success', 'Rating dan review berhasil ditambahkan.');
        }
    }

    public function destroy(Review $review)
    {
        // Check if user owns the review
        if ($review->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Anda tidak dapat menghapus review ini.');
        }

        // Log deletion activity
        ActivityLog::log(
            auth()->id(),
            'user_delete_review',
            'Review',
            $review->id,
            'User deleted review for book: ' . $review->book->title
        );

        $review->delete();
        return back()->with('success', 'Review berhasil dihapus.');
    }
}
