<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void {
    Schema::create('site_settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique(); // e.g., 'permit_instructions', 'emergency_contacts'
        $table->longtext('value');          // The actual text/JSON
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
