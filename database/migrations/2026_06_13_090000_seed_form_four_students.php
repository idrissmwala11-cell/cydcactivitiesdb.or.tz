<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $students = [
            ['MARTHA MWIGA', 'MORAVIAN USSOKE', 'F'],
            ['NAOMI NICKSON MSHOLO', 'MORAVIAN USSOKE', 'F'],
            ['JOHN ERNEST', 'MORAVIAN USSOKE', 'M'],
            ['DAVID ELIA CHAMBALA', 'MORAVIAN USSOKE', 'M'],
            ['FATUMA KADALA', 'MORAVIAN USSOKE', 'F'],
            ['CHARLES GIBSON EMMANUEL', 'MORAVIAN USSOKE', 'M'],
            ['ASIA SELEMAN MGAWE', 'MORAVIAN USSOKE', 'F'],
            ['STANSLAUS PAULO', 'MORAVIAN USSOKE', 'M'],
            ['ELIZABETH PETER MSANGAMA', 'MORAVIAN USSOKE', 'F'],
            ['HARUN SHABAN FARAJ', 'MORAVIAN USSOKE', 'M'],
            ['HADIJA THABIT SALUMU', 'MORAVIAN USSOKE', 'F'],
            ['ASIA SALUM SAID', 'MORAVIAN USSOKE', 'F'],
            ['DERIK MESHACK EMMANUEL', 'EAGT URAMBO', 'M'],
            ['ASHERI BENEDICTO JAMES', 'EAGT URAMBO', 'M'],
            ['SHABAN MASUDI SHABAN', 'EAGT URAMBO', 'M'],
            ['ISSA PHILIPO SHEKELO', 'EAGT URAMBO', 'M'],
            ['AZAMA REVOCATUS ZUNDA', 'EAGT URAMBO', 'M'],
            ['GLORIA KUGHABA KAINDA', 'EAGT URAMBO', 'F'],
            ['CESILIA JOSHUA ELIAS', 'EAGT URAMBO', 'F'],
            ['HALIMA MAGANGA IDDI', 'EAGT URAMBO', 'F'],
            ['MUSA LEONARD BENEDICTO', 'EAGT URAMBO', 'M'],
            ['AMRI MSAFIRI RASHIDI', 'EAGT URAMBO', 'M'],
            ['GASPEL', 'EAGT URAMBO', 'M'],
            ['MERCY PAUL', 'EAGT URAMBO', 'F'],
            ['ANGELINA SADOCK MVUGUTO', 'EAGT URAMBO', 'F'],
            ['ASHURA KATEGILE IDDI', 'EAGT URAMBO', 'F'],
            ['AISHA KATALWA NASSORO', 'EAGT URAMBO', 'F'],
            ['KULWA YOHANA', 'EAGT URAMBO', 'M'],
            ['DOTTO YOHANA', 'EAGT URAMBO', 'M'],
            ['JUMA NASSIBU KLIABASAGA', 'EAGT URAMBO', 'M'],
            ['SAUDA SAIDI ADAM', 'EAGT URAMBO', 'F'],
            ['SOPHIA PETER SINYANYA', 'EAGT URAMBO', 'F'],
            ['BETH PETER MAHITANYI', 'FPCT URAMBO', 'F'],
            ['GOODLUCK GABRIEL KIDUGALO', 'FPCT URAMBO', 'M'],
            ['TUOMBE THOBIAS MAHINJA', 'FPCT URAMBO', 'M'],
            ['PETER ISAYA', 'FPCT URAMBO', 'M'],
            ['JAPHETH FLORENCE', 'FPCT URAMBO', 'M'],
            ['EMELDA ABUBAKARI', 'FPCT URAMBO', 'F'],
            ['JONATHAN FRANK NGOYE', 'FPCT URAMBO', 'M'],
            ['REBECCA NOAH MKUDE', 'FPCT URAMBO', 'F'],
            ['FEISAL MRISHO KAYEKI', 'FPCT URAMBO', 'M'],
            ['PRISCA AYUBU RAMADHAN', 'FPCT URAMBO', 'F'],
        ];

        $subjectIds = DB::table('form_two_subjects')
            ->where('education_level', 'secondary')
            ->where('is_active', true)
            ->whereNotIn('abbreviation', ['HTM', 'ICS', 'COMM', 'B/KP', 'B/KNW', 'LIT-ENG'])
            ->orderBy('display_order')
            ->pluck('id');

        DB::transaction(function () use ($students, $subjectIds) {
            foreach ($students as [$candidateName, $fcpName, $sex]) {
                $studentId = DB::table('form_two_students')
                    ->where('education_level', 'secondary')
                    ->where('class_level', 'Form 4')
                    ->where('candidate_name', $candidateName)
                    ->where('fcp_name', $fcpName)
                    ->value('id');

                if (! $studentId) {
                    $studentId = DB::table('form_two_students')->insertGetId([
                        'student_number' => $this->nextStudentNumber(),
                        'candidate_name' => $candidateName,
                        'fcp_name' => $fcpName,
                        'sex' => $sex,
                        'education_level' => 'secondary',
                        'class_level' => 'Form 4',
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

    private function nextStudentNumber(): string
    {
        $number = 1;

        do {
            $studentNumber = 'F4-'.str_pad((string) $number++, 3, '0', STR_PAD_LEFT);
        } while (DB::table('form_two_students')->where('student_number', $studentNumber)->exists());

        return $studentNumber;
    }
};
