<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

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
        
        // Get preview content if it's a text file
        $previewContent = null;
        $previewExists = false;
        
        if ($book->preview_path && Storage::disk('public')->exists($book->preview_path)) {
            $previewExists = true;
            $extension = pathinfo($book->preview_path, PATHINFO_EXTENSION);
            
            if ($extension === 'txt') {
                try {
                    $previewContent = Storage::disk('public')->get($book->preview_path);
                    // Limit to first 5000 characters for performance
                    $previewContent = substr($previewContent, 0, 5000);
                } catch (\Exception $e) {
                    $previewContent = null;
                }
            }
        }
        
        return view('books.show', compact('book', 'previewContent', 'previewExists'));
    }

    public function previewDownload(Book $book)
    {
        // Check if preview exists
        if (!$book->preview_path || !Storage::disk('public')->exists($book->preview_path)) {
            return abort(404, 'Preview tidak ditemukan');
        }

        // Get file extension
        $extension = pathinfo($book->preview_path, PATHINFO_EXTENSION);
        
        // For PDFs and images, we can show inline; for text, download
        $disposition = in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif']) ? 'inline' : 'attachment';

        // Create a clean filename
        $filename = 'preview_' . str_replace(' ', '_', $book->title) . '.' . $extension;

        return Storage::disk('public')->download(
            $book->preview_path,
            $filename,
            ['Content-Disposition' => $disposition]
        );
    }
}
