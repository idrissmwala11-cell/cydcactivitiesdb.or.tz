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
        Schema::create('skills_attendance', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('teacher_name');
            $table->string('lesson_topic');
            $table->integer('present_count');
            $table->text('teacher_comments')->nullable();
            $table->text('supervisor_comments')->nullable();
            $table->text('lesson_topic_details');
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
        Schema::dropIfExists('skills_attendance');
    }
};
