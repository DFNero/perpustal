<?php

namespace App\Http\Controllers;

use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category')->latest()->get();
        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
        $book->load('category', 'libraries');
        return view('books.show', compact('book'));
    }
}
