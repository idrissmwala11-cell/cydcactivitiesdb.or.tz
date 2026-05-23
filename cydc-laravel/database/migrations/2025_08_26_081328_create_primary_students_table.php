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
        Schema::create('primary_students', function (Blueprint $table) {
            $table->id();
            $table->string('jina'); // Student name
            $table->string('shule'); // School name
            $table->string('darasa'); // Class/Grade
            $table->date('tarehe'); // Date
            $table->string('ufaulu'); // Performance
            $table->string('nafasi'); // Position/Rank
            $table->text('masomopenda')->nullable(); // Favorite subjects
            $table->text('maono')->nullable(); // Vision/Goals
            $table->text('changamoto')->nullable(); // Challenges
            $table->string('kiswahili')->nullable(); // Kiswahili grade
            $table->string('hisabati')->nullable(); // Mathematics grade
            $table->string('english')->nullable(); // English grade
            $table->string('uraia')->nullable(); // Civics grade
            $table->string('history')->nullable(); // History grade
            $table->string('maarifa')->nullable(); // General knowledge grade
            $table->string('stadi')->nullable(); // Skills grade
            $table->string('sayansi')->nullable(); // Science grade
            $table->text('maoni')->nullable(); // Comments
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
        Schema::dropIfExists('primary_students');
    }
};
