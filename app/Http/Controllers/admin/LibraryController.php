<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $libraries = Library::latest()->get();
        return view('admin.libraries.index', compact('libraries'));
    }

    public function create()
    {
        return view('admin.libraries.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        Library::create($data);

        return redirect()->route('admin.libraries.index')->with('success', 'Perpustakaan berhasil dibuat.');
    }

    public function edit(Library $library)
    {
        return view('admin.libraries.edit', compact('library'));
    }

    public function update(Request $request, Library $library)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $library->update($data);

        return redirect()->route('admin.libraries.index')->with('success', 'Perpustakaan berhasil diperbarui.');
    }

    public function destroy(Library $library)
    {
        $library->delete(); // soft delete (libraries table has deleted_at)
        return redirect()->route('admin.libraries.index')->with('success', 'Perpustakaan dihapus.');
    }
}
