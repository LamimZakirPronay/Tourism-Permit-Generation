<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'], // The email you will use to login
            [
                'name' => 'System Admin',
                'password' => Hash::make('admin12345678'), // The password (hashed)
            ]
        );
    }
}