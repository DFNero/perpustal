<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        $search = request('search');
        $category = request('category');
        $year = request('year');
        $publisher = request('publisher');
        
        $query = Book::with('category');
        
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('isbn', 'like', '%' . $search . '%');
        }
        
        if ($category) {
            $query->where('category_id', $category);
        }
        
        if ($year) {
            $query->where('year', $year);
        }
        
        if ($publisher) {
            $query->where('publisher', 'like', '%' . $publisher . '%');
        }
        
        $books = $query->latest()->get();
        
        // Get filter options
        $categories = \App\Models\Category::orderBy('name')->get();
        $years = Book::select('year')->distinct()->whereNotNull('year')->orderBy('year', 'desc')->pluck('year');
        $publishers = Book::select('publisher')->distinct()->whereNotNull('publisher')->orderBy('publisher')->pluck('publisher');
        
        return view('books.index', compact('books', 'search', 'category', 'year', 'publisher', 'categories', 'years', 'publishers'));
    }

    public function show(Book $book)
    {
        $book->load('category', 'libraries');
        
        // Get libraries in user's city, sorted by distance (if user is logged in)
        $nearestLibraries = [];
        if (auth()->check() && auth()->user()->city_id && auth()->user()->latitude && auth()->user()->longitude) {
            // Get libraries only from user's city, sorted by distance
            $allLibrariesInCity = \App\Helpers\DistanceHelper::getLibrariesInUserCity(
                auth()->user()->city_id,
                auth()->user()->latitude,
                auth()->user()->longitude
            );
            
            // Filter to only show libraries that have this book
            $nearestLibraries = array_filter($allLibrariesInCity, function ($lib) use ($book) {
                return $book->libraries->contains('id', $lib['id']);
            });
        }
        
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
        
        return view('books.show', compact('book', 'previewContent', 'previewExists', 'nearestLibraries'));
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
