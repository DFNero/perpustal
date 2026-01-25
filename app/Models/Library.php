<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Library extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'city_id',
        'address',
        'latitude',
        'longitude',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_library')
            ->withPivot('stock')
            ->withTimestamps();
    }
}
