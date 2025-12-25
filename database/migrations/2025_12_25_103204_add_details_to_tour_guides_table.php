<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tour_guides', function (Blueprint $table) {
            if (! Schema::hasColumn('tour_guides', 'parent_name')) {
                $table->string('parent_name')->nullable()->after('name');
            }
            if (! Schema::hasColumn('tour_guides', 'blood_group')) {
                $table->string('blood_group')->nullable()->after('parent_name');
            }
            if (! Schema::hasColumn('tour_guides', 'marital_status')) {
                $table->string('marital_status')->nullable()->after('blood_group');
            }
            if (! Schema::hasColumn('tour_guides', 'spouse_name')) {
                $table->string('spouse_name')->nullable()->after('marital_status');
            }
            if (! Schema::hasColumn('tour_guides', 'email')) {
                $table->string('email')->unique()->nullable()->after('spouse_name');
            }
            if (! Schema::hasColumn('tour_guides', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable()->after('contact');
            }
            if (! Schema::hasColumn('tour_guides', 'nid_number')) {
                $table->string('nid_number')->unique()->nullable()->after('license_id');
            }
            if (! Schema::hasColumn('tour_guides', 'address')) {
                $table->text('address')->nullable()->after('nid_number');
            }
            if (! Schema::hasColumn('tour_guides', 'attachment_path')) {
                $table->string('attachment_path')->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tour_guides', function (Blueprint $table) {
            $columns = [
                'parent_name', 'blood_group', 'marital_status',
                'spouse_name', 'email', 'emergency_contact',
                'nid_number', 'address', 'attachment_path',
            ];
            foreach ($columns as $col) {
                if (Schema::hasColumn('tour_guides', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
