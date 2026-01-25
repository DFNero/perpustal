<?php
// app\Http\Controllers\admin\LibraryController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Library;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index()
    {
        $search = request('search');
        
        $query = Library::query();
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('address', 'like', '%' . $search . '%');
        }
        
        $libraries = $query->latest()->get();
        return view('admin.libraries.index', compact('libraries', 'search'));
    }

    public function create()
    {
        $cities = \App\Models\City::orderBy('name')->get();
        return view('admin.libraries.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        Library::create($data);

        return redirect()->route('admin.libraries.index')->with('success', 'Perpustakaan berhasil dibuat.');
    }

    public function edit(Library $library)
    {
        $cities = \App\Models\City::orderBy('name')->get();
        return view('admin.libraries.edit', compact('library', 'cities'));
    }

    public function update(Request $request, Library $library)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'city_id' => 'required|exists:cities,id',
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
