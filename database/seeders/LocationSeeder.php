<?php

use App\Models\Location;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    public function run()
    {
        Location::create([
            'name' => 'Titik Pembuangan 1',
            'description' => 'Area perumahan',
            'category' => 'Sampah Tidak Bakar',
            'latitude' => -6.1751,
            'longitude' => 106.8650,
        ]);
    }
}

