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
        Schema::create('secondary_school_info', function (Blueprint $table) {
            $table->id();
            $table->string('jina'); // Student name
            $table->string('shule'); // School name
            $table->string('kidato'); // Form level
            $table->string('ufaulu'); // Performance
            $table->string('division'); // Division
            $table->date('tarehe_kumaliza')->nullable(); // Completion date
            $table->string('combination')->nullable(); // Subject combination
            $table->string('kiswahili')->nullable(); // Kiswahili grade
            $table->string('mathematics')->nullable(); // Mathematics grade
            $table->string('english')->nullable(); // English grade
            $table->string('civics')->nullable(); // Civics grade
            $table->string('history')->nullable(); // History grade
            $table->string('biology')->nullable(); // Biology grade
            $table->string('chemistry')->nullable(); // Chemistry grade
            $table->string('bookkeeping')->nullable(); // Bookkeeping grade
            $table->string('commerce')->nullable(); // Commerce grade
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
        Schema::dropIfExists('secondary_school_info');
    }
};
