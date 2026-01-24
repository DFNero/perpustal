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
        'canceled_at',
        'cancel_reason',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'canceled_at' => 'datetime',
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

    /**
     * Check if borrowing is canceled
     */
    public function isCanceled(): bool
    {
        return $this->canceled_at !== null;
    }

    /**
     * Scope: Get only active (not canceled) borrowings
     */
    public function scopeActive($query)
    {
        return $query->whereNull('canceled_at');
    }

    /**
     * Scope: Get only canceled borrowings
     */
    public function scopeCanceled($query)
    {
        return $query->whereNotNull('canceled_at');
    }
}
