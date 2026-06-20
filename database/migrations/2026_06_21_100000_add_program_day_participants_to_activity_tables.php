<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('masomo_ya_mtaala') && ! Schema::hasColumn('masomo_ya_mtaala', 'category')) {
            Schema::table('masomo_ya_mtaala', function (Blueprint $table) {
                $table->string('category')->nullable()->after('topic');
            });
        }

        foreach (['masomo_ya_mtaala', 'masomo_ya_fani', 'special_programs'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'present_participants')) {
                    $table->text('present_participants')->nullable()->after('user_id');
                }

                if (! Schema::hasColumn($tableName, 'absent_participants')) {
                    $table->text('absent_participants')->nullable()->after('present_participants');
                }
            });
        }
    }

    public function down(): void
    {
        foreach (['masomo_ya_mtaala', 'masomo_ya_fani', 'special_programs'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $columns = collect(['present_participants', 'absent_participants'])
                    ->filter(fn ($column) => Schema::hasColumn($tableName, $column))
                    ->all();

                if ($columns !== []) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
