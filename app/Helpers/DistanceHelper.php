<?php

namespace App\Helpers;

use App\Models\Library;

class DistanceHelper
{
    /**
     * Calculate distance between two coordinates using Haversine formula
     * Returns distance in kilometers
     */
    public static function haversineDistance($lat1, $lon1, $lat2, $lon2): float
    {
        $earth_radius = 6371; // Earth's radius in kilometers

        $lat1_rad = deg2rad($lat1);
        $lon1_rad = deg2rad($lon1);
        $lat2_rad = deg2rad($lat2);
        $lon2_rad = deg2rad($lon2);

        $dlat = $lat2_rad - $lat1_rad;
        $dlon = $lon2_rad - $lon1_rad;

        $a = sin($dlat / 2) * sin($dlat / 2) +
             cos($lat1_rad) * cos($lat2_rad) *
             sin($dlon / 2) * sin($dlon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earth_radius * $c;

        return round($distance, 2);
    }

    /**
     * Get libraries in user's city, sorted by distance
     * Returns array of libraries in same city as user, sorted closest first
     */
    public static function getLibrariesInUserCity($userCityId, $userLatitude, $userLongitude)
    {
        // Get only libraries in user's city
        $libraries = Library::where('city_id', $userCityId)->get();
        
        if ($libraries->isEmpty()) {
            return [];
        }
        
        $librariesWithDistance = $libraries->map(function ($library) use ($userLatitude, $userLongitude) {
            return [
                'id' => $library->id,
                'name' => $library->name,
                'address' => $library->address,
                'latitude' => $library->latitude,
                'longitude' => $library->longitude,
                'distance' => self::haversineDistance(
                    (float) $userLatitude,
                    (float) $userLongitude,
                    (float) $library->latitude,
                    (float) $library->longitude
                ),
                'library' => $library,
            ];
        })->sortBy('distance');

        return $librariesWithDistance->values()->all();
    }

    /**
     * Get all libraries with distance, sorted by proximity
     * Returns array of libraries with distance, sorted closest first
     */
    public static function getAllLibrariesWithDistance($latitude, $longitude)
    {
        $libraries = Library::all();
        
        $librariesWithDistance = $libraries->map(function ($library) use ($latitude, $longitude) {
            return [
                'id' => $library->id,
                'name' => $library->name,
                'address' => $library->address,
                'latitude' => $library->latitude,
                'longitude' => $library->longitude,
                'distance' => self::haversineDistance(
                    (float) $latitude,
                    (float) $longitude,
                    (float) $library->latitude,
                    (float) $library->longitude
                ),
                'library' => $library,
            ];
        })->sortBy('distance');

        return $librariesWithDistance->values()->all();
    }

    /**
     * Get nearest libraries for a user based on their coordinates
     * Returns array of libraries with distance, sorted by proximity, limited to $limit
     */
    public static function getNearestLibraries($latitude, $longitude, $limit = 5)
    {
        $libraries = Library::all();
        
        $librariesWithDistance = $libraries->map(function ($library) use ($latitude, $longitude) {
            return [
                'id' => $library->id,
                'name' => $library->name,
                'address' => $library->address,
                'latitude' => $library->latitude,
                'longitude' => $library->longitude,
                'distance' => self::haversineDistance(
                    (float) $latitude,
                    (float) $longitude,
                    (float) $library->latitude,
                    (float) $library->longitude
                ),
                'library' => $library,
            ];
        })->sortBy('distance');

        return $librariesWithDistance->take($limit)->values()->all();
    }
}
