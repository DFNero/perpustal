<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Library;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $libraries = [
            [
                'name' => 'Perpustakaan Umum Kota Surabaya',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2636290,
                'longitude' => 112.7448630,
            ],
            [
                'name' => 'Arisza Library & Learning',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.3374010,
                'longitude' => 112.7183560,
            ],
            [
                'name' => 'Perpustakaan Taman Flora',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2955370,
                'longitude' => 112.7615430,
            ],
            [
                'name' => 'Perpustakaan Kota Surabaya',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.3275970,
                'longitude' => 112.7756470,
            ],
            [
                'name' => 'Perpustakaan Medayu Agung',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.3319370,
                'longitude' => 112.7983970,
            ],
            [
                'name' => 'Read Coffee & Library',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.3234740,
                'longitude' => 112.7917800,
            ],
            [
                'name' => 'Libreria Eatery',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2927160,
                'longitude' => 112.7555270,
            ],
            [
                'name' => 'Perpustakaan Museum Pendidikan',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2561080,
                'longitude' => 112.7428480,
            ],
            [
                'name' => 'Dinas Perpustakaan dan Kearsipan Provinsi Jawa Timur',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2893600,
                'longitude' => 112.7682440,
            ],
            [
                'name' => 'Perpustakaan Umum Pahlawan',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2490960,
                'longitude' => 112.7381650,
            ],
            [
                'name' => 'The Library',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2927730,
                'longitude' => 112.6723810,
            ],
            [
                'name' => 'Kamush Library Depot',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2788160,
                'longitude' => 112.7877180,
            ],
            [
                'name' => 'Perpustakaan Unair Kampus B',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2726067,
                'longitude' => 112.7583743,
            ],
            [
                'name' => 'Perpustakaan Unair Kampus C',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2681520,
                'longitude' => 112.7852050,
            ],
            [
                'name' => 'Perpustakaan Unesa',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.3011280,
                'longitude' => 112.6730390,
            ],
            [
                'name' => 'Perpustakaan ITS',
                'address' => 'Surabaya, Jawa Timur',
                'latitude' => -7.2816370,
                'longitude' => 112.7956520,
            ],
        ];

        foreach ($libraries as $library) {
            Library::create($library);
        }
    }
}
