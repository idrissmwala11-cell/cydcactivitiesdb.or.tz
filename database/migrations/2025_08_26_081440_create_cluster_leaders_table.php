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
        Schema::create('cluster_leaders', function (Blueprint $table) {
            $table->id();
            $table->string('cluster_name'); // Cluster name
            $table->string('yds_name'); // YDS name
            $table->integer('leaders_count'); // Number of leaders
            $table->string('meeting_count'); // Meeting count
            $table->string('gethro_practice'); // Gethro practice
            $table->date('term_end'); // Term end date
            $table->text('additional_notes')->nullable(); // Additional notes
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cluster_leaders');
    }
};
