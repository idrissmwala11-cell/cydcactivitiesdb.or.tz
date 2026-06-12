<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $students = $this->students();
        $subjectIds = DB::table('form_two_subjects')
            ->where('education_level', 'primary')
            ->whereIn('abbreviation', ['KISW', 'KING', 'HIS', 'SAY', 'MAJ', 'URA'])
            ->pluck('id');

        if ($subjectIds->count() !== 6) {
            throw new RuntimeException('Masomo sita ya shule ya msingi hayajakamilika.');
        }

        $usedStudentNumbers = DB::table('form_two_students')
            ->where('student_number', 'like', 'P4-%')
            ->pluck('student_number')
            ->flip();
        $nextNumber = 1;

        DB::transaction(function () use ($students, $subjectIds, $usedStudentNumbers, &$nextNumber) {
            foreach ($students as $student) {
                $studentId = DB::table('form_two_students')
                    ->where('education_level', 'primary')
                    ->where('class_level', 'Darasa la Nne')
                    ->where('candidate_name', $student['candidate_name'])
                    ->where('fcp_name', $student['fcp_name'])
                    ->value('id');

                if (! $studentId) {
                    do {
                        $studentNumber = 'P4-'.str_pad((string) $nextNumber++, 3, '0', STR_PAD_LEFT);
                    } while (isset($usedStudentNumbers[$studentNumber]));

                    $usedStudentNumbers[$studentNumber] = true;
                    $studentId = DB::table('form_two_students')->insertGetId([
                        'student_number' => $studentNumber,
                        'candidate_name' => $student['candidate_name'],
                        'fcp_name' => $student['fcp_name'],
                        'sex' => $student['sex'],
                        'education_level' => 'primary',
                        'class_level' => 'Darasa la Nne',
                        'is_active' => true,
                        'created_by' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                foreach ($subjectIds as $subjectId) {
                    DB::table('form_two_student_subject')->updateOrInsert(
                        ['student_id' => $studentId, 'subject_id' => $subjectId],
                        ['registered' => true]
                    );
                }
            }
        });
    }

    public function down(): void
    {
        // Imported student records are intentionally preserved on rollback.
    }

    private function students(): array
    {
        $path = database_path('data/form_four_primary_students.csv');
        $handle = fopen($path, 'rb');

        if ($handle === false) {
            throw new RuntimeException("Imeshindikana kusoma {$path}.");
        }

        $students = [];

        try {
            $headers = fgetcsv($handle);

            while (($values = fgetcsv($handle)) !== false) {
                if (count($values) !== count($headers)) {
                    continue;
                }

                $student = array_combine($headers, $values);

                if (trim($student['candidate_name']) !== '') {
                    $students[] = $student;
                }
            }
        } finally {
            fclose($handle);
        }

        return $students;
    }
};
