<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('local_sponsorships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('child_name');
            $table->unsignedInteger('child_age');
            $table->string('child_location');
            $table->string('sponsor_type');
            $table->string('sponsor_name');
            $table->string('local_number');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('local_sponsorships');
    }
};
