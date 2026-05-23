<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_visitations', function (Blueprint $table) {
            $table->id();
            $table->string('participant_name');
            $table->string('registration_number');
            $table->string('school_name');
            $table->string('class_level');
            $table->string('participant_presence');
            $table->string('academic_progress');
            $table->text('academic_challenges')->nullable();
            $table->string('discipline_status');
            $table->text('bad_behaviors')->nullable();
            $table->string('cleanliness_status');
            $table->text('teacher_comments')->nullable();
            $table->text('visitor_comments')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_visitations');
    }
};
