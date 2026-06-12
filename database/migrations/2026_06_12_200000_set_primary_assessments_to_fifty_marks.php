<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('form_two_assessments')
            ->where('education_level', 'primary')
            ->update(['max_marks' => 50]);
    }

    public function down(): void
    {
        DB::table('form_two_assessments')
            ->where('education_level', 'primary')
            ->update(['max_marks' => 100]);
    }
};
