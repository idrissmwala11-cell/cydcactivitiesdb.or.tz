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
        Schema::create('college_info', function (Blueprint $table) {
            $table->id();
            $table->string('student_name'); // Student name
            $table->string('college_name'); // College name
            $table->string('course'); // Course name
            $table->string('program_level'); // Program level
            $table->string('other_level')->nullable(); // Other level if program_level is 'other'
            $table->date('completion_date'); // Completion date
            $table->text('physical_address'); // Physical address
            $table->text('challenges')->nullable(); // Challenges faced
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
        Schema::dropIfExists('college_info');
    }
};
