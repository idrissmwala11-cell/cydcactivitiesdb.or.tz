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
        Schema::create('talents_information', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('participant_number');
            $table->integer('age');
            $table->string('gender');
            $table->string('mentor')->nullable();
            $table->string('talent_type');
            $table->text('talent_description');
            $table->string('talent_duration');
            $table->boolean('has_competed')->default(false);
            $table->text('competition_details')->nullable();
            $table->text('achievements')->nullable();
            $table->boolean('needs_training')->default(false);
            $table->text('training_details')->nullable();
            $table->text('comments')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talents_information');
    }
};
