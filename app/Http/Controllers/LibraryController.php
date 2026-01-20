<?php

namespace App\Http\Controllers;

use App\Models\Library;

class LibraryController extends Controller
{
    public function map()
    {
        $libraries = Library::select('id', 'name', 'address', 'latitude', 'longitude')->get();
        return view('libraries.map', compact('libraries'));
    }
}
