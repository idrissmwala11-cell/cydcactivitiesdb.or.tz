<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_day_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('participant_number');
            $table->string('participant_name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['user_id', 'participant_number']);
        });

        foreach (['masomo_ya_mtaala', 'masomo_ya_fani', 'special_programs'] as $tableName) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (! Schema::hasColumn($tableName, 'present_count')) {
                    $table->unsignedInteger('present_count')->default(0)->after('present_participants');
                }

                if (! Schema::hasColumn($tableName, 'absent_count')) {
                    $table->unsignedInteger('absent_count')->default(0)->after('absent_participants');
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
                $columns = collect(['present_count', 'absent_count'])
                    ->filter(fn ($column) => Schema::hasColumn($tableName, $column))
                    ->all();

                if ($columns !== []) {
                    $table->dropColumn($columns);
                }
            });
        }

        Schema::dropIfExists('program_day_participants');
    }
};
