<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('absent_participants')) {
            return;
        }

        Schema::table('absent_participants', function (Blueprint $table) {
            if (!Schema::hasColumn('absent_participants', 'attendance_type')) {
                $table->string('attendance_type')->default('curriculum')->after('attendance_id');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('absent_participants')) {
            return;
        }

        Schema::table('absent_participants', function (Blueprint $table) {
            if (Schema::hasColumn('absent_participants', 'attendance_type')) {
                $table->dropColumn('attendance_type');
            }
        });
    }
};
