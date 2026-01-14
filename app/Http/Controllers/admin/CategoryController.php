<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|',
            'slug' => 'required|string|max:255|unique:categories,slug',
        ]);

        Category::create([
            'name' => $validated['name'], 
            'slug' => $validated['slug'], 
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category berhasil ditambahkan.');
    }

    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui');
    }
    
    public function destroy(Category $category)
    {
        $category->delete(); // soft delete (categories table has deleted_at)
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

}
