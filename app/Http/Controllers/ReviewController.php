<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
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
            return back()->with('success', 'Rating dan review diperbarui.');
        } else {
            Review::create($validated);
            return back()->with('success', 'Rating dan review berhasil ditambahkan.');
        }
    }

    public function destroy(Review $review)
    {
        // Check if user owns the review
        if ($review->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return back()->with('error', 'Anda tidak dapat menghapus review ini.');
        }

        $review->delete();
        return back()->with('success', 'Review berhasil dihapus.');
    }
}
