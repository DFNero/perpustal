<?php

// general
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowingController;

// admin
use App\Http\Controllers\Admin\LibraryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LibraryBookController;
use App\Http\Controllers\Admin\BookController as AdminBookController;

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
    Route::view('/dashboard', 'dashboard')
        ->middleware('role:user')
        ->name('dashboard');

    // admin roles ke dashboard
    Route::view('/admin/dashboard', 'admin.dashboard')
        ->middleware('role:admin')
        ->name('admin.dashboard');

    // staff roles ke dashboard
    Route::view('/staff/dashboard', 'staff.dashboard')
        ->middleware('role:staff')
        ->name('staff.dashboard');

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

// borrowings line (user)
Route::middleware('auth')->group(function () {
    // User borrowings - canonical user page
    Route::get('/borrowings', [BorrowingController::class, 'index'])
        ->name('borrowings.index');
    
    Route::get('/notifications', [BorrowingController::class, 'notifications'])
        ->name('notifications.index');
    
    Route::post('/notifications/{notification}/read', [BorrowingController::class, 'markNotificationAsRead'])
        ->name('notifications.read');
    
    Route::post('/borrow/{book}', [BorrowingController::class, 'store'])
        ->name('borrow.store');
});
// borrowings end line

// staff line
Route::middleware(['auth', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        // line borrowings
        Route::get('/borrowings', [StaffBorrowingController::class, 'index'])
            ->name('borrowings.index');
        
        Route::get('/borrowings/approved', [StaffBorrowingController::class, 'approved'])
            ->name('borrowings.approved');

        Route::patch('/borrowings/{borrowing}/approve', [StaffBorrowingController::class, 'approve'])
            ->name('borrowings.approve');

        Route::patch('/borrowings/{borrowing}/reject', [StaffBorrowingController::class, 'reject'])
            ->name('borrowings.reject');
        
        Route::patch('/borrowings/{borrowing}/return', [StaffBorrowingController::class, 'markAsReturned'])
            ->name('borrowings.return');
    });
        // end line borrowings


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
        // line books
        
        Route::get('/books', [AdminBookController::class, 'index'])
            ->name('books.index');
        Route::get('/books/create', [AdminBookController::class, 'create'])
            ->name('books.create');
        Route::post('/books', [AdminBookController::class, 'store'])
            ->name('books.store');
        Route::get('/books/{book}/edit', [AdminBookController::class, 'edit'])
            ->name('books.edit');
        Route::put('/books/{book}', [AdminBookController::class, 'update'])
            ->name('books.update');
        Route::delete('/books/{book}', [AdminBookController::class, 'destroy'])
            ->name('books.destroy');
        
        // end line books
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

// borrowings line user
Route::middleware(['auth'])
    ->group(function () {
        Route::post('/borrowings', [BorrowingController::class, 'store'])
            ->name('borrowings.store');
    });
// borrowings line end user


require __DIR__.'/auth.php';
