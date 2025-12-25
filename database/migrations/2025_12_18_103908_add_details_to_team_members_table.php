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
        $table->string('fathers_name')->nullable();
        $table->integer('age')->nullable();
        $table->text('address')->nullable();
        $table->string('profession')->nullable();
        $table->string('contact_number')->nullable();
        $table->string('emergency_contact')->nullable();
        $table->string('blood_group')->nullable();
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
