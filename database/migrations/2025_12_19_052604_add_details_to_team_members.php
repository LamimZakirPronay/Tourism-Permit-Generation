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
    Schema::table('team_members', function (Blueprint $table) {
        $table->string('gender', 20)->after('age');
        $table->string('age_category', 20)->after('gender'); // Adult, Children, Infant
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            //
        });
    }
};
