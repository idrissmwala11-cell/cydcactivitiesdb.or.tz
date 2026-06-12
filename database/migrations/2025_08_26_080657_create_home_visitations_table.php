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
        Schema::create('home_visitations', function (Blueprint $table) {
            $table->id();
            $table->string('jina');
            $table->string('namba');
            $table->string('shule');
            $table->string('darasa');
            $table->string('last_program');
            $table->string('likes_program');
            $table->text('participant_comments')->nullable();
            $table->string('mtaa');
            $table->string('mazingira');
            $table->string('nyumba');
            $table->string('paa');
            $table->string('choo');
            $table->string('milo');
            $table->integer('wanaume');
            $table->integer('wanawake');
            $table->text('tabia')->nullable();
            $table->date('visit_date');
            $table->text('maoni')->nullable();
            $table->string('mtembelezaji');
            $table->string('nafasi');
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
        Schema::dropIfExists('home_visitations');
    }
};
