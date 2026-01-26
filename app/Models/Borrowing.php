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
        'due_date',
        'return_condition',
        'damage_notes',
        'notes',
        'canceled_at',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'due_date' => 'date',
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
     * Get days remaining until due date (only for approved borrowings)
     * Returns negative if overdue
     */
    public function daysUntilDue(): ?int
    {
        if (!$this->due_date || $this->status !== 'approved') {
            return null;
        }
        return now()->diffInDays($this->due_date, false);
    }

    /**
     * Check if borrowing is overdue (only for approved borrowings)
     */
    public function isOverdue(): bool
    {
        if ($this->status !== 'approved' || !$this->due_date) {
            return false;
        }
        return now()->isAfter($this->due_date);
    }

    /**
     * Get days overdue (only if overdue)
     */
    public function daysOverdue(): ?int
    {
        if (!$this->isOverdue()) {
            return null;
        }
        return abs(now()->diffInDays($this->due_date, false));
    }

    /**
     * Get due date status for display
     * Returns: 'on-time', 'warning', or 'overdue'
     */
    public function getDueDateStatus(): string
    {
        if ($this->status !== 'approved' || !$this->due_date) {
            return 'unknown';
        }

        $daysRemaining = $this->daysUntilDue();
        
        if ($daysRemaining < 0) {
            return 'overdue';
        } elseif ($daysRemaining <= 3) {
            return 'warning';
        } else {
            return 'on-time';
        }
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
