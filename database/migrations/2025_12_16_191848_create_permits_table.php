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
        Schema::create('permits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('group_name');
            $table->string('tourist_name'); // Ensure this exists
            $table->integer('total_members');
            $table->string('leader_name');
            $table->string('leader_nid')->unique();
            $table->string('contact_number');
            $table->string('email')->unique();
            $table->date('visit_date');
            $table->string('area_name');
            $table->boolean('payment_status')->default(true);
            $table->string('document_path')->nullable();
            $table->dateTime('arrival_datetime');
            $table->dateTime('departure_datetime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permits');
    }
};
