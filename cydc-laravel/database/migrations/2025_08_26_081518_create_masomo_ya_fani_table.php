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
        Schema::create('masomo_ya_fani', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Date
            $table->string('teacher'); // Teacher name
            $table->string('fani_type'); // Subject type
            $table->string('topic'); // Topic
            $table->text('student_preferences')->nullable(); // Student preferences
            $table->text('student_feedback')->nullable(); // Student feedback
            $table->text('teacher_feedback')->nullable(); // Teacher feedback
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
        Schema::dropIfExists('masomo_ya_fani');
    }
};
