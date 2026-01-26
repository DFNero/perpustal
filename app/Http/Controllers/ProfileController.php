<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\City;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $cities = City::orderBy('name')->get();
        
        return view('profile.edit', [
            'user' => $request->user(),
            'cities' => $cities,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // Handle KTP photo upload
        if ($request->hasFile('ktp_photo')) {
            // Delete old KTP photo if it exists
            if ($request->user()->ktp_photo_path) {
                Storage::disk('public')->delete($request->user()->ktp_photo_path);
            }
            // Store new KTP photo
            $data['ktp_photo_path'] = $request->file('ktp_photo')->store('ktp-photos', 'public');
        }

        $request->user()->fill($data);
        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
