<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculum_attendance_participants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('curriculum_attendance_id');
            $table->string('participant_name');
            $table->string('participant_number')->nullable();
            $table->enum('status', ['present', 'absent'])->default('present');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->timestamps();

            $table->foreign('curriculum_attendance_id', 'cap_curr_att_fk')
                ->references('id')
                ->on('curriculum_attendance')
                ->onDelete('cascade');

            $table->foreign('user_id', 'cap_user_fk')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('curriculum_attendance_participants');
    }
};
