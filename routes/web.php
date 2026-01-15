<?php

// general
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserBorrowingController;

// admin
use App\Http\Controllers\Admin\LibraryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LibraryBookController;

// staff
use App\Http\Controllers\Staff\BorrowingController as StaffBorrowingController;

// utils
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
        
        // line categories
        
        Route::get('/categories', [CategoryController::class, 'index'])
            ->name('categories.index');
            // create
        Route::get('/categories/create', [CategoryController::class, 'create'])
            ->name('categories.create');
            // simpan
        Route::post('/categories', [CategoryController::class, 'store'])
            ->name('categories.store');
            // edit
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])
            ->name('categories.edit');
            // update
        Route::put('/categories/{category}', [CategoryController::class, 'update'])
            ->name('categories.update');
            // delete
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
            ->name('categories.destroy');
            
        // end line categories
        // 
        // line library
        
        Route::get('/libraries', [LibraryController::class, 'index'])
            ->name('libraries.index');
            // create
        Route::get('/libraries/create', [LibraryController::class, 'create'])
            ->name('libraries.create');
            // simpan
        Route::post('/libraries', [LibraryController::class, 'store'])
            ->name('libraries.store');
            // edit
        Route::get('/libraries/{library}/edit', [LibraryController::class, 'edit'])
            ->name('libraries.edit');
            // update
        Route::put('/libraries/{library}', [LibraryController::class, 'update'])
            ->name('libraries.update');
            // delete
        Route::delete('/libraries/{library}', [LibraryController::class, 'destroy'])    
            ->name('libraries.destroy');
            
        // end line library
        //
        // line book
        
        Route::get('/libraries/books', [LibraryBookController::class, 'allBooks'])
            ->name('libraries.books.all');

        Route::get('/libraries/{library}/books', [LibraryBookController::class, 'index'])
            ->name('libraries.books.index');

        Route::get('/libraries/{library}/books/create', [LibraryBookController::class, 'create'])
            ->name('libraries.books.create');

        Route::post('/libraries/{library}/books', [LibraryBookController::class, 'store'])
            ->name('libraries.books.store');

        Route::get('/libraries/{library}/books/{book}/edit', [LibraryBookController::class, 'edit'])
            ->name('libraries.books.edit');

        Route::put('/libraries/{library}/books/{book}', [LibraryBookController::class, 'update'])
            ->name('libraries.books.update');

        Route::delete('/libraries/{library}/books/{book}', [LibraryBookController::class, 'destroy'])
            ->name('libraries.books.destroy');

        // end line book
    });


// admin end line

// Notifications 
Route::post('/notifications/read', function () {
    auth()->user()->unreadNotifications->markAsRead();
    return back();
})->middleware('auth');
// notifications end line


require __DIR__.'/auth.php';
