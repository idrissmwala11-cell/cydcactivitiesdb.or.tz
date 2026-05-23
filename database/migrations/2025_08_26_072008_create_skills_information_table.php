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
        Schema::create('skills_information', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->enum('gender', ['Male', 'Female']);
            $table->string('student_id');
            $table->string('skill_category');
            $table->text('specific_skills');
            $table->string('skills_type');
            $table->text('group_skills_details')->nullable();
            $table->string('skill_level');
            $table->string('has_certification')->nullable();
            $table->text('certification_details')->nullable();
            $table->string('mentor')->nullable();
            $table->text('challenges')->nullable();
            $table->text('support_received')->nullable();
            $table->text('comments')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skills_information');
    }
};
