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
        if (! Schema::hasTable('masomo_ya_fani')) {
            return;
        }

        Schema::table('masomo_ya_fani', function (Blueprint $table) {
            // Only add 'status' if it doesn't exist yet
            if (!Schema::hasColumn('masomo_ya_fani', 'status')) {
                $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])
                      ->default('draft')
                      ->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('masomo_ya_fani')) {
            return;
        }

        Schema::table('masomo_ya_fani', function (Blueprint $table) {
            // Only drop 'status' if it exists
            if (Schema::hasColumn('masomo_ya_fani', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
