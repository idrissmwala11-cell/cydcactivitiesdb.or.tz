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
        Schema::create('national_leader_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('leader_id'); // Foreign key to national_leaders
            $table->string('leader_name'); // Leader name
            $table->string('participant_number'); // Participant number
            $table->string('position'); // Leader position
            $table->enum('gender', ['male', 'female']); // Gender
            $table->timestamps();
            
            $table->foreign('leader_id')->references('id')->on('national_leaders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('national_leader_details');
    }
};
