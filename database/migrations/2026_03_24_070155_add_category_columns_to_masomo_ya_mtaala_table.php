<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('masomo_ya_mtaala')) {
            return;
        }

        Schema::table('masomo_ya_mtaala', function (Blueprint $table) {
            foreach (['kiroho', 'kimwili', 'kiakili', 'kijamii'] as $column) {
                if (! Schema::hasColumn('masomo_ya_mtaala', $column)) {
                    $table->string($column)->nullable();
                }
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('masomo_ya_mtaala')) {
            return;
        }

        Schema::table('masomo_ya_mtaala', function (Blueprint $table) {
            $columns = collect(['kiroho', 'kimwili', 'kiakili', 'kijamii'])
                ->filter(fn (string $column) => Schema::hasColumn('masomo_ya_mtaala', $column))
                ->all();

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
