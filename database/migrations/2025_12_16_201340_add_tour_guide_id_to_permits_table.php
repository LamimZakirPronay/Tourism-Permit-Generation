<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            // Add the new column, allowing null initially (no guide assigned yet)
            $table->foreignId('tour_guide_id')->nullable()->constrained('tour_guides')->after('area_name');
        });
    }

    public function down(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->dropForeign(['tour_guide_id']);
            $table->dropColumn('tour_guide_id');
        });
    }
};