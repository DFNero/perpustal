<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\LocationHelper;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $cities = LocationHelper::getCitiesForDropdown();
        return view('auth.register', compact('cities'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'city' => ['required', 'exists:cities,id'],
            'ktp_number' => ['required', 'string', 'size:16', 'unique:users,ktp_number', 'regex:/^[0-9]{16}$/'],
            'ktp_photo' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'ktp_number.size' => 'Nomor KTP harus 16 digit',
            'ktp_number.regex' => 'Nomor KTP hanya boleh berisi angka',
            'ktp_number.unique' => 'Nomor KTP sudah terdaftar',
            'ktp_photo.required' => 'Foto KTP harus diupload',
            'ktp_photo.image' => 'File harus berupa gambar',
            'ktp_photo.mimes' => 'Format gambar harus JPG atau PNG',
            'ktp_photo.max' => 'Ukuran file maksimal 2MB',
        ]);

        // Handle KTP photo upload
        $ktpPhotoPath = null;
        if ($request->hasFile('ktp_photo')) {
            // Store in public disk with directory ktp-photos
            $ktpPhotoPath = $request->file('ktp_photo')->store('ktp-photos', 'public');
        }

        // Get coordinates from city
        $cityData = LocationHelper::getCoordinatesByCity($request->city);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'city_id' => $request->city,
            'latitude' => $cityData['latitude'] ?? null,
            'longitude' => $cityData['longitude'] ?? null,
            'ktp_number' => $request->ktp_number,
            'ktp_photo_path' => $ktpPhotoPath,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('books.index', absolute: false));
    }
}
