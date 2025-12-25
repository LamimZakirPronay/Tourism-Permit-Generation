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
    Schema::table('users', function (Blueprint $table) {
        $table->string('ba_no')->unique()->after('id'); // Personal Number (BA/P/J/OR)
        $table->string('rank')->after('name');        // Major, Captain, Lt Col, etc.
        $table->string('corps')->after('rank');        // Infantry, Artillery, Engineers, etc.
        $table->string('unit')->nullable();           // e.g., 12 East Bengal
        $table->string('formation')->nullable();      // e.g., 9 Div, 6 Indep Armd Bde
        $table->string('appointment')->nullable();    // GSO-2, Adjutant, DQ, etc.
        $table->string('contact_no')->nullable();
        $table->string('blood_group', 5)->nullable();
        $table->date('date_of_commission')->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
