<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create([
            'name' => 'Surabaya',
            'latitude' => -7.2575,
            'longitude' => 112.7521,
        ]);

        City::create([
            'name' => 'Sidoarjo',
            'latitude' => -7.4424,
            'longitude' => 112.7103,
        ]);

        City::create([
            'name' => 'Gresik',
            'latitude' => -7.1620,
            'longitude' => 112.6670,
        ]);

        City::create([
            'name' => 'Mojokerto',
            'latitude' => -7.4794,
            'longitude' => 112.4309,
        ]);

        City::create([
            'name' => 'Lamongan',
            'latitude' => -6.8839,
            'longitude' => 112.2216,
        ]);

        City::create([
            'name' => 'Bangkalan',
            'latitude' => -7.0452,
            'longitude' => 112.7457,
        ]);

        City::create([
            'name' => 'Pamekasan',
            'latitude' => -7.1904,
            'longitude' => 113.4827,
        ]);

        City::create([
            'name' => 'Sumenep',
            'latitude' => -7.0222,
            'longitude' => 113.8589,
        ]);
    }
}
