<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $this->removeSubjectsForClass('Form 2', ['CIV', 'ICS', 'B/KP', 'B/KNW', 'LIT-ENG']);
        $this->removeSubjectsForClass('Form 4', ['HTM', 'ICS', 'COMM', 'B/KP', 'B/KNW', 'LIT-ENG']);
    }

    public function down(): void
    {
        // Intentionally left blank: removed marks/subject selections should not be recreated automatically.
    }

    private function removeSubjectsForClass(string $classLevel, array $subjectAbbreviations): void
    {
        $studentIds = DB::table('form_two_students')
            ->where('education_level', 'secondary')
            ->where('class_level', $classLevel)
            ->pluck('id');

        $subjectIds = DB::table('form_two_subjects')
            ->where('education_level', 'secondary')
            ->whereIn('abbreviation', $subjectAbbreviations)
            ->pluck('id');

        if ($studentIds->isEmpty() || $subjectIds->isEmpty()) {
            return;
        }

        DB::table('form_two_marks')
            ->whereIn('student_id', $studentIds)
            ->whereIn('subject_id', $subjectIds)
            ->delete();

        DB::table('form_two_student_subject')
            ->whereIn('student_id', $studentIds)
            ->whereIn('subject_id', $subjectIds)
            ->delete();
    }
};
