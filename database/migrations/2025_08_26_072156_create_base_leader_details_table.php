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
        Schema::create('base_leader_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_leader_id')->constrained('base_leaders')->onDelete('cascade');
            $table->string('leader_name');
            $table->string('position');
            $table->enum('gender', ['male', 'female']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('base_leader_details');
    }
};
