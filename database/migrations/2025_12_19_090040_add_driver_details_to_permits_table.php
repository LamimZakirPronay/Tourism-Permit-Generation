<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            // Vehicle Details
            $table->string('vehicle_ownership')->nullable()->comment('Local Car or Personal Car');
            $table->string('vehicle_reg_no')->nullable();
            
            // Driver Details
            $table->string('driver_name')->nullable();
            $table->string('driver_contact')->nullable();
            $table->string('driver_emergency_contact')->nullable();
            $table->string('driver_blood_group', 5)->nullable();
            $table->string('driver_license_no')->nullable();
            $table->string('driver_nid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->dropColumn([
                'vehicle_ownership',
                'vehicle_reg_no',
                'driver_name',
                'driver_contact',
                'driver_emergency_contact',
                'driver_blood_group',
                'driver_license_no',
                'driver_nid'
            ]);
        });
    }
};