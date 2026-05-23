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
        Schema::create('alevel_students', function (Blueprint $table) {
            $table->id();
            $table->string('student_name'); // Student name
            $table->string('school_name'); // School name
            $table->string('school_address'); // School address
            $table->string('form_level'); // Form level (Form 5 or Form 6)
            $table->date('completion_date')->nullable(); // Completion date
            $table->string('performance'); // Performance
            $table->string('division'); // Division
            $table->string('points'); // Points scored
            $table->string('department'); // Department/combination
            $table->string('other_combination')->nullable(); // Other combination if department is 'other'
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
        Schema::dropIfExists('alevel_students');
    }
};
