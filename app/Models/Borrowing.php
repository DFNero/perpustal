<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Book;
use App\Models\Library;

class Borrowing extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'library_id',
        'status',
        'staff_id',
        'borrow_date',
        'return_date',
        'notes',
    ];

    protected $dates = [
        'borrow_date',
        'return_date',
    ];

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function library()
    {
        return $this->belongsTo(Library::class);
    }
}
