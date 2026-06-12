<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_two_subjects', function (Blueprint $table) {
            $table->string('education_level', 20)->default('secondary');
        });

        Schema::table('form_two_students', function (Blueprint $table) {
            $table->string('education_level', 20)->default('secondary');
            $table->string('class_level', 30)->default('Form 2');
            $table->index(['education_level', 'class_level'], 'form_two_students_level_class_index');
        });

        Schema::table('form_two_assessments', function (Blueprint $table) {
            $table->string('education_level', 20)->default('secondary');
            $table->string('class_level', 30)->default('Form 2');
            $table->index(['education_level', 'class_level'], 'form_two_assessments_level_class_index');
        });

        $now = now();
        DB::table('form_two_subjects')->insert([
            ['code' => 'P01', 'name' => 'KISWAHILI', 'abbreviation' => 'KISW', 'display_order' => 1, 'is_active' => true, 'education_level' => 'primary', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'P02', 'name' => 'KIINGEREZA', 'abbreviation' => 'KING', 'display_order' => 2, 'is_active' => true, 'education_level' => 'primary', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'P03', 'name' => 'HISABATI', 'abbreviation' => 'HIS', 'display_order' => 3, 'is_active' => true, 'education_level' => 'primary', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'P04', 'name' => 'SAYANSI NA TEKNOLOJIA', 'abbreviation' => 'SAY', 'display_order' => 4, 'is_active' => true, 'education_level' => 'primary', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'P05', 'name' => 'MAARIFA YA JAMII', 'abbreviation' => 'MAJ', 'display_order' => 5, 'is_active' => true, 'education_level' => 'primary', 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'P06', 'name' => 'URAIA NA MAADILI', 'abbreviation' => 'URA', 'display_order' => 6, 'is_active' => true, 'education_level' => 'primary', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        DB::table('form_two_subjects')->where('education_level', 'primary')->delete();

        Schema::table('form_two_assessments', function (Blueprint $table) {
            $table->dropIndex('form_two_assessments_level_class_index');
            $table->dropColumn(['education_level', 'class_level']);
        });

        Schema::table('form_two_students', function (Blueprint $table) {
            $table->dropIndex('form_two_students_level_class_index');
            $table->dropColumn(['education_level', 'class_level']);
        });

        Schema::table('form_two_subjects', function (Blueprint $table) {
            $table->dropColumn('education_level');
        });
    }
};
