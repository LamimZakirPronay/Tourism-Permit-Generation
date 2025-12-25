<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::create('team_members', function (Blueprint $table) {
        $table->id();
        $table->foreignId('permit_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->string('fathers_name');
        $table->integer('age');
        $table->text('address');
        $table->string('profession');
        $table->string('contact_number');
        $table->string('emergency_contact');
        $table->string('blood_group');
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};