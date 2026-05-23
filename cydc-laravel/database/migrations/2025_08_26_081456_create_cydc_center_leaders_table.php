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
        Schema::create('cydc_center_leaders', function (Blueprint $table) {
            $table->id();
            $table->integer('leader_count'); // Number of leaders
            $table->text('challenges')->nullable(); // Challenges faced
            $table->text('comments')->nullable(); // Comments
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
        Schema::dropIfExists('cydc_center_leaders');
    }
};
