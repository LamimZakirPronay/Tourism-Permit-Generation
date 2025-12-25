<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('tour_guides', function (Blueprint $table) {
        $table->string('parent_name')->nullable();
        $table->string('marital_status')->nullable();
        $table->string('spouse_name')->nullable();
        $table->string('email')->unique()->nullable();
        // 'contact' and 'license_id' likely exist, adding others:
        $table->string('nid_number')->unique()->nullable();
        $table->text('address')->nullable();
        $table->string('emergency_contact')->nullable();
        $table->string('blood_group', 5)->nullable();
        $table->string('attachment_path')->nullable(); // For NID/File storage
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guides', function (Blueprint $table) {
            //
        });
    }
};
