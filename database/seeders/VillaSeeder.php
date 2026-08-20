<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillaSeeder extends Seeder
{

    public function run(): void
    {
        Villa::create([
            'title' => 'Vila Luxury Sunset',
            'slug' => Str::slug('Vila Luxury Sunset'),
            'description' => 'Vila mewah dengan kolam renang pribadi dan pemandangan laut.',
            'price_per_night' => 1500000,
            'capacity' => 6,
            'location' => 'Batu, Malang',
            'status' => 'available',
        ]);
    }
}
