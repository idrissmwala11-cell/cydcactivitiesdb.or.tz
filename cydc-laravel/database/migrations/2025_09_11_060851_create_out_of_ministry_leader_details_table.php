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
        Schema::create('out_of_ministry_leader_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('out_of_ministry_leader_id')->constrained('out_of_ministry_leaders')->onDelete('cascade');
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
        Schema::dropIfExists('out_of_ministry_leader_details');
    }
};
