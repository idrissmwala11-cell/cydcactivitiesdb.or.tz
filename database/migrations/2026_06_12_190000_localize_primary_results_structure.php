<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $subjects = [
            'P01' => ['KISWAHILI', 'KISW', 1],
            'P02' => ['KIINGEREZA', 'KING', 2],
            'P03' => ['HISABATI', 'HIS', 3],
            'P04' => ['SAYANSI NA TEKNOLOJIA', 'SAY', 4],
            'P05' => ['MAARIFA YA JAMII', 'MAJ', 5],
            'P06' => ['URAIA NA MAADILI', 'URA', 6],
        ];

        foreach ($subjects as $code => [$name, $abbreviation, $order]) {
            DB::table('form_two_subjects')->where('code', $code)->update([
                'name' => $name,
                'abbreviation' => $abbreviation,
                'display_order' => $order,
                'is_active' => true,
                'education_level' => 'primary',
                'updated_at' => now(),
            ]);
        }

        DB::table('form_two_subjects')->where('code', 'P07')->delete();

        DB::table('form_two_students')
            ->where('education_level', 'primary')
            ->where('class_level', 'Standard 4')
            ->update(['class_level' => 'Darasa la Nne']);

        DB::table('form_two_students')
            ->where('education_level', 'primary')
            ->where('class_level', 'Standard 7')
            ->update(['class_level' => 'Darasa la Saba']);

        DB::table('form_two_assessments')
            ->where('education_level', 'primary')
            ->where('class_level', 'Standard 4')
            ->update(['class_level' => 'Darasa la Nne']);

        DB::table('form_two_assessments')
            ->where('education_level', 'primary')
            ->where('class_level', 'Standard 7')
            ->update(['class_level' => 'Darasa la Saba']);
    }

    public function down(): void
    {
        DB::table('form_two_subjects')->where('code', 'P02')->update(['name' => 'ENGLISH LANGUAGE', 'abbreviation' => 'ENGL']);
        DB::table('form_two_subjects')->where('code', 'P03')->update(['name' => 'MATHEMATICS', 'abbreviation' => 'MATH']);
        DB::table('form_two_subjects')->where('code', 'P04')->update(['name' => 'SCIENCE AND TECHNOLOGY', 'abbreviation' => 'SCI']);
        DB::table('form_two_subjects')->where('code', 'P05')->update(['name' => 'SOCIAL STUDIES', 'abbreviation' => 'S/ST']);
        DB::table('form_two_subjects')->where('code', 'P06')->update(['name' => 'CIVIC AND MORAL EDUCATION', 'abbreviation' => 'CME']);

        DB::table('form_two_subjects')->insert([
            'code' => 'P07',
            'name' => 'VOCATIONAL SKILLS',
            'abbreviation' => 'V/SK',
            'display_order' => 7,
            'is_active' => true,
            'education_level' => 'primary',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
};
