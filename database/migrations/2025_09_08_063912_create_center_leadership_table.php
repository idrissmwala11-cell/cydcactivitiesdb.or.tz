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
        Schema::create('center_leadership', function (Blueprint $table) {
            $table->id();
            $table->string('center_name'); // Idadi ya Viongozi
            $table->json('leadership_list'); // ORODHA YA VIONGOZI - stores array of leaders with Namba, Jina la Kiongozi, Namba ya Kiongozi, Cheo
            $table->text('challenges')->nullable(); // Changamoto Wanayopitia
            $table->text('feedback')->nullable(); // Maoni ya Ziada
            $table->string('status')->default('pending'); // For admin approval
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User who submitted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_leadership');
    }
};
