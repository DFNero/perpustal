<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserBorrowingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Staff\BorrowingController as StaffBorrowingController;
use Illuminate\Support\Facades\Route;

// public route guests
Route::get('/', fn () => view('welcome'));
Route::get('/about', fn () => view('about'));


// auth line
Route::middleware(['auth'])->group(function () {

    // default roles user ke dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // admin roles ke dashboard
    Route::view('/admin/dashboard', 'admin.dashboard')
        ->middleware(['auth'])
        ->name('admin.dashboard');

    // staff roles ke dashboard
    Route::view('/staff/dashboard', 'staff.dashboard')
        ->middleware(['auth'])
        ->name('staff.dashboard');

    // User peminjaman
    Route::get('/my-borrowings', [UserBorrowingController::class, 'index'])
        ->name('user.borrowings.index');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// auth end line

// books line
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');

Route::post('/borrow/{book}', [BorrowingController::class, 'store'])
    ->name('borrow.store')
    ->middleware('auth');
// books end line

// staff line
Route::middleware(['auth'])->prefix('staff')->group(function () {
    Route::get('/borrowings', [StaffBorrowingController::class, 'index'])
        ->name('staff.borrowings.index');
    
    Route::patch('/borrowings/{borrowing}/approve', [StaffBorrowingController::class, 'approve'])
        ->name('staff.borrowings.approve');
    
    Route::patch('/borrowings/{borrowing}/reject', [StaffBorrowingController::class, 'reject'])
        ->name('staff.borrowings.reject');
});

Route::patch('/staff/borrowings/{borrowing}/return', 
    [BorrowingController::class, 'return']
)->name('staff.borrowings.return');
// staff end line

// admin line
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');
    });
// admin end line

// Notifications 
Route::post('/notifications/read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->middleware('auth');
// notifications end line


require __DIR__.'/auth.php';
