<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    // Update PERMITS table
    Schema::table('permits', function (Blueprint $table) {
        if (!Schema::hasColumn('permits', 'arrival_datetime')) {
            $table->dateTime('arrival_datetime')->after('area_name')->nullable();
        }
        if (!Schema::hasColumn('permits', 'departure_datetime')) {
            $table->dateTime('departure_datetime')->after('arrival_datetime')->nullable();
        }
    });

    // Update TEAM_MEMBERS table
    Schema::table('team_members', function (Blueprint $table) {
        if (!Schema::hasColumn('team_members', 'fathers_name')) {
            $table->string('fathers_name')->after('name')->nullable();
        }
        if (!Schema::hasColumn('team_members', 'age')) {
            $table->integer('age')->after('fathers_name')->nullable();
        }
        if (!Schema::hasColumn('team_members', 'address')) {
            $table->text('address')->after('age')->nullable();
        }
        if (!Schema::hasColumn('team_members', 'profession')) {
            $table->string('profession')->after('address')->nullable();
        }
        if (!Schema::hasColumn('team_members', 'contact_number')) {
            $table->string('contact_number')->after('profession')->nullable();
        }
        if (!Schema::hasColumn('team_members', 'emergency_contact')) {
            $table->string('emergency_contact')->after('contact_number')->nullable();
        }
        if (!Schema::hasColumn('team_members', 'blood_group')) {
            $table->string('blood_group')->after('emergency_contact')->nullable();
        }
    });
}

    public function down(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->dropColumn(['arrival_datetime', 'departure_datetime']);
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['fathers_name', 'age', 'address', 'profession', 'contact_number', 'emergency_contact', 'blood_group']);
        });
    }
};