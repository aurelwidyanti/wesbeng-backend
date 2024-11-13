<?php
namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        DB::table('locations')->insert([
            [
                'name' => 'Titik Pembuangan 1',
                'description' => 'Area perumahan',
                'category' => 'Sampah Tidak Bakar',
                'latitude' => -6.1751,
                'longitude' => 106.8650,
            ],
            [
                'name' => 'Titik Pembuangan 2',
                'description' => 'Area komersial',
                'category' => 'Sampah Organik',
                'latitude' => -6.2000,
                'longitude' => 106.8450,
            ],
            [
                'name' => 'Titik Pembuangan 3',
                'description' => 'Area industri',
                'category' => 'Sampah B3',
                'latitude' => -6.3000,
                'longitude' => 106.9000,
            ],
        ]);
    }
}
