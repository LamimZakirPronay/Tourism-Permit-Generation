<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('permits', function (Blueprint $table) {
        // Leader Details
        if (!Schema::hasColumn('permits', 'leader_name')) {
            $table->string('leader_name')->nullable();
        }
        if (!Schema::hasColumn('permits', 'leader_nid')) {
            $table->string('leader_nid')->nullable();
        }
        if (!Schema::hasColumn('permits', 'email')) {
            $table->string('email')->nullable();
        }
        if (!Schema::hasColumn('permits', 'contact_number')) {
            $table->string('contact_number')->nullable();
        }

        // Payment Columns
        if (!Schema::hasColumn('permits', 'amount')) {
            $table->decimal('amount', 10, 2)->default(0.00);
        }
        if (!Schema::hasColumn('permits', 'payment_status')) {
            $table->string('payment_status')->default('pending');
        }
        if (!Schema::hasColumn('permits', 'bkash_trx_id')) {
            $table->string('bkash_trx_id')->nullable();
        }
        if (!Schema::hasColumn('permits', 'bkash_payment_id')) {
            $table->string('bkash_payment_id')->nullable();
        }
        if (!Schema::hasColumn('permits', 'total_members')) {
            $table->integer('total_members')->default(0);
        }
    });
}

    public function down(): void
    {
        Schema::table('permits', function (Blueprint $table) {
            $table->dropColumn([
                'leader_name', 'leader_nid', 'email', 'contact_number',
                'amount', 'payment_status', 'bkash_trx_id', 'bkash_payment_id', 'total_members'
            ]);
        });
    }
};