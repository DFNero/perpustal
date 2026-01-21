<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;

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
                // Silently fail, let validation handle it in form
                return null;
            }
        }

        return null;
    }

    private function handlePreviewUpload(Request $request): ?string
    {
        // If file is uploaded
        if ($request->hasFile('preview')) {
            $file = $request->file('preview');
            $extension = $file->getClientOriginalExtension();
            $filename = 'previews/' . time() . '_' . uniqid() . '.' . $extension;
            return $file->storeAs('previews', basename($filename), 'public');
        }

        // If URL is provided, download and save
        if ($request->filled('preview_url')) {
            try {
                $url = $request->input('preview_url');
                
                // Validate URL format
                if (!filter_var($url, FILTER_VALIDATE_URL)) {
                    throw new \Exception('Invalid URL format');
                }

                // Download file
                $response = Http::timeout(10)->get($url);
                
                if ($response->failed()) {
                    throw new \Exception('Failed to download file');
                }

                // Determine file extension from URL or content-type
                $extension = 'pdf'; // default
                if (preg_match('/\.(\w+)$/', parse_url($url, PHP_URL_PATH), $matches)) {
                    $ext = strtolower($matches[1]);
                    if (in_array($ext, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt'])) {
                        $extension = $ext;
                    }
                }
                
                // Generate filename
                $filename = 'previews/' . time() . '_' . uniqid() . '.' . $extension;
                
                // Save file
                Storage::disk('public')->put($filename, $response->body());
                
                return $filename;
            } catch (\Exception $e) {
                // Silently fail, let validation handle it in form
                return null;
            }
        }

        return null;
    }

    public function index()
    {
        $search = request('search');
        
        $query = Book::with('category');
        
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('author', 'like', '%' . $search . '%')
                ->orWhere('isbn', 'like', '%' . $search . '%');
        }
        
        $books = $query->latest()->get();
        return view('admin.books.index', compact('books', 'search'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.create', compact('categories'));
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
            'preview' => 'nullable|file|mimes:pdf,jpeg,jpg,png,gif,txt|max:5120',
            'preview_url' => 'nullable|url',
        ]);

        // Handle cover upload or URL
        $coverPath = $this->handleCoverUpload($request);
        if ($coverPath) {
            $data['cover_path'] = $coverPath;
        }

        // Handle preview upload or URL
        $previewPath = $this->handlePreviewUpload($request);
        if ($previewPath) {
            $data['preview_path'] = $previewPath;
        }

        Book::create($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dibuat.');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
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
            'preview' => 'nullable|file|mimes:pdf,jpeg,jpg,png,gif,txt|max:5120',
            'preview_url' => 'nullable|url',
        ]);

        // Handle cover upload or URL
        $coverPath = $this->handleCoverUpload($request);
        if ($coverPath) {
            // Delete old cover if exists
            if ($book->cover_path) {
                Storage::disk('public')->delete($book->cover_path);
            }
            $data['cover_path'] = $coverPath;
        }

        // Handle preview upload or URL
        $previewPath = $this->handlePreviewUpload($request);
        if ($previewPath) {
            // Delete old preview if exists
            if ($book->preview_path) {
                Storage::disk('public')->delete($book->preview_path);
            }
            $data['preview_path'] = $previewPath;
        }

        $book->update($data);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        // Delete cover if exists
        if ($book->cover_path) {
            Storage::disk('public')->delete($book->cover_path);
        }
        // Delete preview if exists
        if ($book->preview_path) {
            Storage::disk('public')->delete($book->preview_path);
        }
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
