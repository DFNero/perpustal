<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $search = request('search');
        
        $query = City::withUserCount();
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $cities = $query->orderBy('name')->get();
        return view('admin.cities.index', compact('cities', 'search'));
    }

    public function create()
    {
        return view('admin.cities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        City::create($request->all());

        return redirect()->route('admin.cities.index')->with('success', 'Kota/Kabupaten berhasil ditambahkan.');
    }

    public function edit(City $city)
    {
        return view('admin.cities.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:cities,name,' . $city->id,
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);

        $city->update($request->all());

        return redirect()->route('admin.cities.index')->with('success', 'Kota/Kabupaten berhasil diperbarui.');
    }

    public function destroy(City $city)
    {
        // Check if any users use this city
        $userCount = \App\Models\User::where('latitude', $city->latitude)
            ->where('longitude', $city->longitude)
            ->count();

        if ($userCount > 0) {
            return redirect()->route('admin.cities.index')->with('error', 'Tidak bisa hapus kota yang masih digunakan oleh ' . $userCount . ' user.');
        }

        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', 'Kota/Kabupaten berhasil dihapus.');
    }
}
