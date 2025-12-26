<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Permit;
use App\Models\TeamMember;
use App\Models\TourGuide;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Clear all tables first
        User::truncate();
        Area::truncate();
        TourGuide::truncate();
        Permit::truncate();
        TeamMember::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Create Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'ba_no' => 'BA-101',
            'rank' => 'Major',
            'unit' => 'Signals',
            'corps' => 'Signals',
            'role' => 'admin',
        ]);

        // 2. Create 5 Tour Guides so the Permits have someone to link to
        for ($i = 1; $i <= 5; $i++) {
            TourGuide::create([
                'name' => "Guide $i",
                'license_id' => "LIC-$i".rand(100, 999),
                'contact' => "0170000000$i",
                'nid_number' => "99887766$i",
                'is_active' => true,
            ]);
        }

        // 3. Create 50 Permits using the Factory
        Permit::factory()->count(50)->create()->each(function ($permit) {
            // 4. For each permit, create 3 random Team Members
            for ($j = 1; $j <= 3; $j++) {
                TeamMember::create([
                    'permit_id' => $permit->id,
                    'name' => "Member $j for ".$permit->leader_name,
                    'fathers_name' => "Father $j",
                    'age' => rand(18, 60),
                    'address' => "Address $j, Dhaka",
                    'profession' => 'Tourist',
                    'contact_number' => '01900000000',
                    'emergency_contact' => '01800000000',
                    'blood_group' => 'B+',
                ]);
            }
        });
    }
}
