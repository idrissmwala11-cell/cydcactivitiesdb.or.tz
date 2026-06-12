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
        Schema::create('masomo_ya_mtaala', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status', 50)->default('draft');
            $table->date('date');
            $table->string('teacher');
            $table->string('subject_type');
            $table->string('age_group')->nullable();
            $table->string('topic')->nullable();
            $table->text('student_feedback')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masomo_ya_mtaala');
    }
};
