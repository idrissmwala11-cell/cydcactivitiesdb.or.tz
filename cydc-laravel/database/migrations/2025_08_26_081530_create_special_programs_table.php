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
        Schema::create('special_programs', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Date
            $table->string('teacher'); // Teacher name
            $table->string('topic'); // Topic
            $table->string('age_range'); // Age range
            $table->text('teacher_feedback'); // Teacher feedback
            $table->text('supervisor_feedback'); // Supervisor feedback
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('special_programs');
    }
};
