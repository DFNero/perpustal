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
        return User::where('latitude', $this->latitude)
            ->where('longitude', $this->longitude);
    }

    /**
     * Scope to add user count via subquery
     */
    public function scopeWithUserCount($query)
    {
        return $query->addSelect([
            'users_count' => \App\Models\User::selectRaw('count(*)')
                ->whereColumn('latitude', 'cities.latitude')
                ->whereColumn('longitude', 'cities.longitude')
        ]);
    }
}
