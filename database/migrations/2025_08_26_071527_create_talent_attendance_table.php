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
        Schema::create('talent_attendance', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('instructor_name');
            $table->string('talent_taught');
            $table->integer('attendance_count');
            $table->text('instructor_comments')->nullable();
            $table->text('supervisor_comments')->nullable();
            $table->string('lesson_topic')->nullable();
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
        Schema::dropIfExists('talent_attendance');
    }
};
