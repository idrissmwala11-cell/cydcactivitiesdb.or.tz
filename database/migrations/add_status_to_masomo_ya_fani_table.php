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
            if (! Schema::hasColumn('masomo_ya_fani', 'status')) {
                $table->enum('status', ['draft', 'submitted', 'approved', 'rejected'])->default('draft');
            }
            if (! Schema::hasColumn('masomo_ya_fani', 'admin_notes')) {
                $table->text('admin_notes')->nullable();
            }
            if (! Schema::hasColumn('masomo_ya_fani', 'submitted_at')) {
                $table->timestamp('submitted_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('masomo_ya_fani')) {
            Schema::table('masomo_ya_fani', function (Blueprint $table) {
                $columns = collect(['status', 'admin_notes', 'submitted_at'])
                    ->filter(fn ($column) => Schema::hasColumn('masomo_ya_fani', $column))
                    ->all();
                if ($columns !== []) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
