<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('talent_absent_participants')) {
            return;
        }

        Schema::table('talent_absent_participants', function (Blueprint $table) {
            if (! Schema::hasColumn('talent_absent_participants', 'status')) {
                $table->string('status', 20)->default('absent')->after('participant_number');
            }

            if (! Schema::hasColumn('talent_absent_participants', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('talent_absent_participants')) {
            return;
        }

        Schema::table('talent_absent_participants', function (Blueprint $table) {
            if (Schema::hasColumn('talent_absent_participants', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('talent_absent_participants', 'user_id')) {
                $table->dropColumn('user_id');
            }
        });
    }
};
