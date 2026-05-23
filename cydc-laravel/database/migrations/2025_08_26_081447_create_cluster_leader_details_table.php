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
        Schema::create('cluster_leader_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cluster_leader_id')->constrained('cluster_leaders')->onDelete('cascade');
            $table->string('leader_name'); // Leader name
            $table->string('position'); // Leader position
            $table->enum('gender', ['male', 'female']); // Gender
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cluster_leader_details');
    }
};
