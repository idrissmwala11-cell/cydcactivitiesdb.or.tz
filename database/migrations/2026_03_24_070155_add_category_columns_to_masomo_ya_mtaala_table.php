<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('masomo_ya_mtaala', function (Blueprint $table) {
            $table->string('kiroho')->nullable();
            $table->string('kimwili')->nullable();
            $table->string('kiakili')->nullable();
            $table->string('kijamii')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('masomo_ya_mtaala', function (Blueprint $table) {
            $table->dropColumn(['kiroho', 'kimwili', 'kiakili', 'kijamii']);
        });
    }
};
