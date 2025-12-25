<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings edit form.
     */
    public function edit()
    {
        // Get all settings as a key => value pair for easy access in the view
        $settings = SiteSetting::pluck('value', 'key');
        return view('admin.settings.edit', compact('settings'));
    }

    /**
     * Update the site settings in the database.
     */
    public function update(Request $request)
    {
        // 1. Handle Logo Upload (Store as Base64 for Cloud/Portability)
        if ($request->hasFile('site_logo')) {
            $image = $request->file('site_logo');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $base64 = 'data:' . $image->getMimeType() . ';base64,' . $imageData;
            
            SiteSetting::updateOrCreate(['key' => 'site_logo'], ['value' => $base64]);
        }

        // 2. Define the list of settings we want to save
        // Input Name from Form => Database Key
        $settingsMap = [
            'site_name'           => 'site_name',
            'instructions'        => 'permit_instructions',
            'contacts'            => 'emergency_contacts',
            'permit_fee'          => 'permit_fee', // Added for pricing control
        ];

        // 3. Loop through the map and update the database
        foreach ($settingsMap as $inputName => $dbKey) {
            if ($request->has($inputName)) {
                SiteSetting::updateOrCreate(
                    ['key' => $dbKey],
                    ['value' => $request->get($inputName)]
                );
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}