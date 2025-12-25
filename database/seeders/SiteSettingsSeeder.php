<?php
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // Default permit fee of 500 BDT
        SiteSetting::updateOrCreate(
            ['key' => 'permit_fee'],
            ['value' => '500', 'description' => 'Standard permit fee in BDT']
        );
    }
}