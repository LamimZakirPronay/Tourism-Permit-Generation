<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // We drop and recreate because changing ID types with existing foreign keys is complex
        Schema::disableForeignKeyConstraints();

        Schema::table('team_members', function (Blueprint $table) {
            $table->dropForeign(['permit_id']);
        });

        Schema::table('permits', function (Blueprint $table) {
            $table->uuid('id')->change(); 
        });

        Schema::table('team_members', function (Blueprint $table) {
            $table->uuid('permit_id')->change();
            $table->foreign('permit_id')->references('id')->on('permits')->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Reverse if necessary
    }
};