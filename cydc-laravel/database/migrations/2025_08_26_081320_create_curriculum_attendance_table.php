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
        Schema::create('curriculum_attendance', function (Blueprint $table) {
            $table->id();
            $table->date('tarehe');
            $table->string('jina_la_mwalimu');
            $table->string('somo');
            $table->integer('wahudhuria');
            $table->text('maoni_ya_mwalimu')->nullable();
            $table->text('maoni_ya_msimamizi')->nullable();
            $table->text('mada');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('curriculum_attendance');
    }
};
