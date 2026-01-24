<?php

// general
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\LibraryController as PublicLibraryController;

// admin
use App\Http\Controllers\Admin\LibraryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LibraryBookController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\ActivityController as AdminActivityController;

// staff
use App\Http\Controllers\Staff\BorrowingController as StaffBorrowingController;
use App\Http\Controllers\Staff\BookController as StaffBookController;
use App\Http\Controllers\Staff\LibraryController as StaffLibraryController;
use App\Http\Controllers\Staff\ActivityController as StaffActivityController;

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
Route::get('/books/{book}/preview', [BookController::class, 'previewDownload'])->name('books.preview');
Route::get('/libraries/map', [PublicLibraryController::class, 'map'])->name('libraries.map');

Route::post('/borrow/{book}', [BorrowingController::class, 'store'])
    ->name('borrow.store')
    ->middleware('auth');

// Reviews
Route::post('/books/{book}/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store')
    ->middleware('auth');

Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])
    ->name('reviews.destroy')
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

    // User Activity Log Routes
    Route::get('/activity-log', [UserActivityController::class, 'activityLog'])
        ->name('activity-log.index');
    
    Route::post('/borrowings/{borrowing}/cancel', [BorrowingController::class, 'cancelBorrow'])
        ->name('borrowings.cancel');
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
        // end line borrowings

        // line books
        Route::get('/books', [StaffBookController::class, 'index'])
            ->name('books.index');
        
        Route::get('/books/create', [StaffBookController::class, 'create'])
            ->name('books.create');
        
        Route::post('/books', [StaffBookController::class, 'store'])
            ->name('books.store');
        
        Route::get('/books/{book}/edit', [StaffBookController::class, 'edit'])
            ->name('books.edit');
        
        Route::put('/books/{book}', [StaffBookController::class, 'update'])
            ->name('books.update');
        // end line books

        // line libraries
        Route::get('/libraries', [StaffLibraryController::class, 'index'])
            ->name('libraries.index');
        
        Route::get('/libraries/{library}', [StaffLibraryController::class, 'show'])
            ->name('libraries.show');
        
        Route::get('/libraries/{library}/add-book', [StaffLibraryController::class, 'addBookForm'])
            ->name('libraries.add-book-form');
        
        Route::post('/libraries/{library}/books', [StaffLibraryController::class, 'storeBook'])
            ->name('libraries.store-book');
        
        Route::get('/libraries/{library}/books/{book}/edit-stock', [StaffLibraryController::class, 'editStockForm'])
            ->name('libraries.edit-stock-form');
        
        Route::patch('/libraries/{library}/books/{book}/stock', [StaffLibraryController::class, 'updateStock'])
            ->name('libraries.update-stock');
        
        Route::delete('/libraries/{library}/books/{book}', [StaffLibraryController::class, 'removeBook'])
            ->name('libraries.remove-book');
        // end line libraries

        // Activity Log
        Route::get('/activity-log', [StaffActivityController::class, 'index'])
            ->name('activity-log.index');
        // end activity log
    });

// staff end line

// admin line
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // line statistics
        Route::get('/statistics', [StatisticsController::class, 'index'])
            ->name('statistics.index');
        // end line statistics

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

        // line users
        Route::get('/users', [UserController::class, 'index'])
            ->name('users.index');
        Route::get('/users/create-staff', [UserController::class, 'createStaff'])
            ->name('users.createStaff');
        Route::post('/users/staff', [UserController::class, 'storeStaff'])
            ->name('users.storeStaff');
        Route::post('/users/{user}/ban', [UserController::class, 'ban'])
            ->name('users.ban');
        Route::post('/users/{user}/unban', [UserController::class, 'unban'])
            ->name('users.unban');
        // end line users

        // line cities
        Route::get('/cities', [CityController::class, 'index'])
            ->name('cities.index');
        Route::get('/cities/create', [CityController::class, 'create'])
            ->name('cities.create');
        Route::post('/cities', [CityController::class, 'store'])
            ->name('cities.store');
        Route::get('/cities/{city}/edit', [CityController::class, 'edit'])
            ->name('cities.edit');
        Route::put('/cities/{city}', [CityController::class, 'update'])
            ->name('cities.update');
        Route::delete('/cities/{city}', [CityController::class, 'destroy'])
            ->name('cities.destroy');
        // end line cities

        // Activity Logs
        Route::get('/activity-logs/worker', [AdminActivityController::class, 'workerLog'])
            ->name('activity-logs.worker');
        Route::get('/activity-logs/user', [AdminActivityController::class, 'userLog'])
            ->name('activity-logs.user');
        // end activity logs
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
