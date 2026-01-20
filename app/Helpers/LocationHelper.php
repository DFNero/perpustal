<?php

namespace App\Helpers;

use App\Models\City;

class LocationHelper
{
    /**
     * Get kota names untuk dropdown (dari database)
     */
    public static function getCitiesForDropdown()
    {
        $cities = City::orderBy('name')->get();
        $result = [];
        foreach ($cities as $city) {
            $result[$city->id] = $city->name;
        }
        return $result;
    }

    /**
     * Get lat/long dari city ID
     */
    public static function getCoordinatesByCity($cityId)
    {
        $city = City::find($cityId);
        if ($city) {
            return [
                'latitude' => $city->latitude,
                'longitude' => $city->longitude,
            ];
        }
        return null;
    }
}
