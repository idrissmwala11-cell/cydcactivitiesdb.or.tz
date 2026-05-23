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
        Schema::create('cydc_leader_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_id'); // Foreign key to cydc_center_leaders
            $table->integer('leader_number'); // Leader number
            $table->string('leader_name'); // Leader name
            $table->string('leader_id'); // Leader ID
            $table->string('leader_position'); // Leader position
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('submission_id')->references('id')->on('cydc_center_leaders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cydc_leader_details');
    }
};
