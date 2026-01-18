<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    private function handleCoverUpload(Request $request): ?string
    {
        // If file is uploaded
        if ($request->hasFile('cover')) {
            return $request->file('cover')->store('covers', 'public');
        }

        // If URL is provided, download and save
        if ($request->filled('cover_url')) {
            try {
                $url = $request->input('cover_url');
                
                // Validate URL format
                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    throw new \Exception('Invalid URL format');
                }

                // Download image
                $response = Http::timeout(10)->get($url);
                
                if ($response->failed()) {
                    throw new \Exception('Failed to download image');
                }

                // Generate filename
                $filename = 'covers/' . time() . '_' . uniqid() . '.jpg';
                
                // Save image
                Storage::disk('public')->put($filename, $response->body());
                
                return $filename;
            } catch (\Exception $e) {
                // Silently fail
                return null;
            }
        }

        return null;
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('staff.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|max:20',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'cover_url' => 'nullable|url',
        ]);

        // Handle cover upload or URL
        $coverPath = $this->handleCoverUpload($request);
        if ($coverPath) {
            $data['cover_path'] = $coverPath;
        }

        Book::create($data);

        return redirect()->route('staff.libraries.index')->with('success', 'Buku berhasil dibuat.');
    }
}
