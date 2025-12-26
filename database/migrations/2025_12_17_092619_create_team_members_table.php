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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id(); // Primary Key for the team member

            // Foreign Key linking to Permits (UUID)
            $table->foreignUuid('permit_id')
                ->constrained('permits')
                ->onDelete('cascade');

            // Personal Information
            $table->string('name');
            $table->string('fathers_name')->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->string('profession')->nullable();

            // Contact Information
            $table->string('contact_number')->nullable();
            $table->string('emergency_contact')->nullable();

            // Medical Information
            $table->string('blood_group')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
