<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/about', fn () => view('about'));

Route::middleware(['auth'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::middleware(['auth'])->group(function () {
        Route::view('/admin/dashboard', 'admin.dashboard')->name('admin.dashboard');
    });


    Route::middleware('role:staff')->group(function () {
        Route::view('/staff/dashboard', 'staff.dashboard')
            ->name('staff.dashboard');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
