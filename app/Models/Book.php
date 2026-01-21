<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'description',
        'cover_path',
        'preview_path',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function libraries()
    {
        return $this->belongsToMany(Library::class, 'book_library')
            ->withPivot('stock')
            ->withTimestamps();
    }

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function ratingCount()
    {
        return $this->reviews()->count();
    }
}