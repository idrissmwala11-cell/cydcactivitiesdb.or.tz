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
        Schema::create('university_info', function (Blueprint $table) {
            $table->id();
            $table->string('student_name'); // Student name
            $table->string('university_name'); // University name
            $table->string('course'); // Course name
            $table->string('program_level'); // Program level (Bachelor, Master, PhD, etc.)
            $table->integer('year_of_study'); // Year of study
            $table->date('completion_date'); // Expected/actual completion date
            $table->string('graduation_status'); // Graduation status
            $table->text('physical_address'); // Physical address
            $table->text('challenges')->nullable(); // Challenges faced
            $table->text('support_needed')->nullable(); // Support needed
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
        Schema::dropIfExists('university_info');
    }
};
