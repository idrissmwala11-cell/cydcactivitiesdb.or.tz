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
        Schema::create('abscent', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_id'); // Foreign key to curriculum_attendance
            $table->string('jina_la_mshiriki'); // Participant name
            $table->string('namba_ya_mshiriki'); // Participant number
            $table->timestamps();
            
            $table->foreign('attendance_id')->references('id')->on('curriculum_attendance')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abscent');
    }
};
