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
        Schema::create('parents_information', function (Blueprint $table) {
            $table->id();
            $table->string('parent_name'); // Parent name
            $table->string('parent_of'); // Parent of (child name)
            $table->string('activity'); // Activity
            $table->string('support_type'); // Support type
            $table->text('address'); // Address
            $table->text('parent_comments')->nullable(); // Parent comments
            $table->text('supervisor_comments')->nullable(); // Supervisor comments
            $table->date('submission_date'); // Submission date
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
        Schema::dropIfExists('parents_information');
    }
};
