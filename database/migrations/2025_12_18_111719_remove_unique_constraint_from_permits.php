<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            // This drops the unique restriction on NID and Email
            $table->dropUnique('permits_leader_nid_unique');
            $table->dropUnique('permits_email_unique');
        });
    }

    public function down(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->unique('leader_nid');
            $table->unique('email');
        });
    }
};