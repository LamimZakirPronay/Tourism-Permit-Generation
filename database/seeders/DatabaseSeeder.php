<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => '1234',
            'email_verified_at' => now(),
            'ba_no' => 'BA-101',
            'rank' => 'Major',
            'unit' => 'Signal Corps',
            'corps' => 'Signals',
            'role' => 'admin',
        ]);
    }
}
