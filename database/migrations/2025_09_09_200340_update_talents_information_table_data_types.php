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
        Schema::table('talents_information', function (Blueprint $table) {
            $table->integer('age')->change();
            $table->boolean('has_competed')->default(false)->change();
            $table->boolean('needs_training')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('talents_information', function (Blueprint $table) {
            $table->string('age')->nullable()->change();
            $table->string('has_competed')->nullable()->change();
            $table->string('needs_training')->nullable()->change();
        });
    }
};
