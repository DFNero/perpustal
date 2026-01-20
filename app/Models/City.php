<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get users from this city
     */
    public function users()
    {
        return $this->hasMany(User::class, 'latitude', 'latitude')
            ->where('longitude', $this->longitude);
    }
}
