<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));
Route::get('/about', fn () => view('about'));

Route::middleware(['auth'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::view('/admin/dashboard', 'admin.dashboard')
        ->middleware(['auth'])
        ->name('admin.dashboard');

    Route::view('/staff/dashboard', 'staff.dashboard')
        ->middleware(['auth'])
        ->name('staff.dashboard');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::post('/borrow/{book}', [BorrowingController::class, 'store'])
    ->name('borrow.store')
    ->middleware('auth');


require __DIR__.'/auth.php';
