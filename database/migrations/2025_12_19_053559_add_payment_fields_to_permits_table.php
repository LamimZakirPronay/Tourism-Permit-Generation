<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            // Check if 'amount' exists before adding it
            if (!Schema::hasColumn('permits', 'amount')) {
                $table->decimal('amount', 10, 2)->default(0.00)->after('status');
            }
            
            // Check if 'payment_status' exists before adding it
            if (!Schema::hasColumn('permits', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->dropColumn(['amount', 'payment_status']);
        });
    }
};