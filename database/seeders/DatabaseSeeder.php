<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Wesbeng',
            'email' => 'admin@wesbeng.com',
            'username' => 'admincuy',
            'phone' => '0987654321',
            'role' => 'admin',
            'password' => 'admin123'
        ]);

        $this->call([
            EducationContentSeeder::class
        ]);
    }
}
