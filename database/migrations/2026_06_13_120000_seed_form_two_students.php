<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $subjectProfiles = [
            'basic' => ['HTM', 'GEO', 'KISW', 'ENGL', 'BIO', 'B/MATH'],
            'full' => ['HTM', 'HIST', 'GEO', 'KISW', 'ENGL', 'PHY', 'CHE', 'BIO', 'B/MATH', 'COMM'],
            'chem_commerce' => ['HTM', 'GEO', 'KISW', 'ENGL', 'CHE', 'BIO', 'B/MATH', 'COMM'],
            'science_commerce' => ['HTM', 'GEO', 'KISW', 'ENGL', 'PHY', 'CHE', 'BIO', 'B/MATH', 'COMM'],
            'commerce' => ['HTM', 'GEO', 'KISW', 'ENGL', 'BIO', 'B/MATH', 'COMM'],
            'five' => ['HTM', 'GEO', 'KISW', 'ENGL', 'BIO'],
        ];

        $students = [
            ['UPENDO SIFA PAULO', 'EAGT URAMBO', 'F', 'basic'],
            ['ADAM HASSAN CHACHA', 'EAGT URAMBO', 'M', 'basic'],
            ['CHIKU SHABAN MALALA', 'EAGT URAMBO', 'F', 'basic'],
            ['SALMA RAJABU', 'EAGT URAMBO', 'F', 'basic'],
            ['ANASTAZIA GODFREY MAGWAYA', 'EAGT URAMBO', 'F', 'basic'],
            ['HASSAN BUNDALA KALUKUMYA', 'EAGT URAMBO', 'M', 'basic'],
            ['LOOKMAN JUMA NZENZELA', 'EAGT URAMBO', 'M', 'basic'],
            ['EMMMANUEL ELIAS EMMANUEL', 'EAGT URAMBO', 'M', 'full'],
            ['RAHEL NGASA', 'EAGT URAMBO', 'F', 'basic'],

            ['REHEMA OMARI', 'USSOKE', 'F', 'basic'],
            ['SALUMU MAGANGA SALUMU', 'USSOKE', 'M', 'basic'],
            ['RAMADHANI JAMALI', 'USSOKE', 'M', 'basic'],
            ['GEORGE SHABAN ISSA', 'USSOKE', 'M', 'basic'],
            ['VERONICA YONA', 'USSOKE', 'F', 'basic'],
            ['CHIKU NASIBU MOHAMED', 'USSOKE', 'F', 'basic'],
            ['FROLA HAGAI ANTONY', 'USSOKE', 'F', 'basic'],
            ['NEEMA EDWAR GEORGE', 'USSOKE', 'F', 'basic'],
            ['REHEMA OMARY', 'USSOKE', 'F', 'basic'],
            ['SALUM MAGANGA SALUM', 'USSOKE', 'M', 'basic'],
            ['RAMADHAN JAMALI', 'USSOKE', 'M', 'basic'],
            ['NEEMA EDWARD', 'USSOKE', 'F', 'basic'],
            ['ALFRED OBADIA', 'USSOKE', 'M', 'basic'],
            ['HADIJA THABIT', 'USSOKE', 'F', 'basic'],
            ['SELINA SIMON ROBERT', 'USSOKE', 'F', 'basic'],
            ['JONATHAN ANDERSON SABIYANKA', 'USSOKE', 'M', 'basic'],
            ['HAMIS ZUBERI LUGENGA', 'USSOKE', 'M', 'basic'],
            ['HELENA GERALD', 'USSOKE', 'F', 'basic'],
            ['HADIJA KASIM HAMAD', 'USSOKE', 'F', 'basic'],
            ['VERONICA YONA DAUDI', 'USSOKE', 'F', 'basic'],
            ['HADIJA HAMISI RAMADHAN', 'USSOKE', 'F', 'basic'],
            ['CLESENSIA ROBERT GEORGE', 'USSOKE', 'F', 'basic'],
            ['REHEMA MASOUD', 'USSOKE', 'F', 'basic'],
            ['MWASITI MGALULA KAFUVI', 'USSOKE', 'F', 'basic'],

            ['SIKUZANI SHABAN NDILILO', 'FPCT URAMBO', 'F', 'basic'],
            ['SADA HASSAN MTOTO', 'FPCT URAMBO', 'F', 'basic'],
            ['SHAKILA SUDI KAGUNA', 'FPCT URAMBO', 'F', 'basic'],
            ['MAGRETH PAULO KUBEJA', 'FPCT URAMBO', 'F', 'basic'],
            ['TEDDY NASHO CHRISTOPHER', 'FPCT URAMBO', 'M', 'basic'],
            ['ROSE MICHAEL ISRAEL', 'FPCT URAMBO', 'F', 'basic'],
            ['EVA AMENYA DAVID', 'FPCT URAMBO', 'F', 'basic'],
            ['BARAKA KIDUGALO', 'FPCT URAMBO', 'M', 'basic'],
            ['EZEKIEL EMANUEL ELIACKIM', 'FPCT URAMBO', 'M', 'basic'],
            ['OMARY SHAKULUWILL', 'FPCT URAMBO', 'M', 'basic'],
            ['RAMADHAN YAHAYA MUNISI', 'FPCT URAMBO', 'M', 'basic'],
            ['ELESI SHADRACK', 'FPCT URAMBO', 'F', 'basic'],
            ['TIENILEE JACKSON', 'FPCT URAMBO', 'F', 'basic'],
            ['MAOMBI GEDION', 'FPCT URAMBO', 'M', 'basic'],

            ['MARIAM RUBEN MASUNGA', 'EAGT MWANZUGI', 'F', 'basic'],
            ['SARAH JUMA KANONI', 'EAGT MWANZUGI', 'F', 'basic'],
            ['MARIA EMANUEL NDALI', 'EAGT MWANZUGI', 'F', 'basic'],
            ['ELIZABETH STEVEN DAUD', 'EAGT MWANZUGI', 'F', 'basic'],
            ['GOYAMBA EMMANUEL NGASSA', 'EAGT MWANZUGI', 'M', 'basic'],
            ['HELENA ISAKA REDI', 'EAGT MWANZUGI', 'F', 'basic'],
            ['CHARLES SAMWEL TULA', 'EAGT MWANZUGI', 'M', 'basic'],

            ['HAMIDA ATHUMAN CHARLES', 'T.A.G ITOBO', 'F', 'chem_commerce'],
            ['RUKIA RAMADHANI', 'T.A.G ITOBO', 'F', 'science_commerce'],
            ['SALOME OMARY MFAUME', 'T.A.G ITOBO', 'F', 'chem_commerce'],
            ['AGNESS NTINGINYA MARCO', 'T.A.G ITOBO', 'F', 'commerce'],
            ['ANDREA MANDALU KAJALA', 'T.A.G ITOBO', 'M', 'science_commerce'],
            ['SAMWELI SIMON KAHETO', 'T.A.G ITOBO', 'M', 'chem_commerce'],
            ['SAID HAMIS LUTONJA', 'T.A.G ITOBO', 'M', 'commerce'],
            ['DAUDI KULWA KULINDWA', 'T.A.G ITOBO', 'M', 'science_commerce'],

            ['OSWAD SWAIBU', 'IPILILI', 'M', 'basic'],
            ['ADAM MCHUMA', 'IPILILI', 'M', 'basic'],
            ['WINFRIDA YOHANA', 'IPILILI', 'F', 'basic'],
            ['FABIAN CHARLES', 'IPILILI', 'M', 'basic'],
            ['IRENE PIUS', 'IPILILI', 'F', 'basic'],
            ['OLIPA BISAYA', 'IPILILI', 'F', 'basic'],
            ['DOTTO ADAM KABALO', 'IPILILI', 'M', 'basic'],
            ['CONSALATA JOSEPH', 'IPILILI', 'F', 'basic'],
            ['BRAYAN NICHOLOUS', 'IPILILI', 'M', 'basic'],
            ['EMANNUEL GODFREY', 'IPILILI', 'M', 'basic'],
            ['RIZIKI MOSES', 'IPILILI', 'F', 'basic'],
            ['IBRAHIM HAMISI', 'IPILILI', 'M', 'basic'],
            ['EBENEZA ERASTO', 'IPILILI', 'M', 'basic'],
            ['ELIZABETH FILBETH', 'IPILILI', 'F', 'basic'],
            ['AGNESS DAUD KAPAMBALA', 'IPILILI', 'F', 'basic'],
            ['LETICIA RICHARD KULWA', 'IPILILI', 'F', 'basic'],
            ['ELIZABETH NJELI MAGUTA', 'IPILILI', 'F', 'basic'],
            ['PILI SALUMU MRISHO', 'IPILILI', 'F', 'basic'],
            ['ADOLPHINA PIUS JAPHET', 'IPILILI', 'F', 'basic'],

            ['ANDREA YUDA', 'FPCT ZIBA', 'M', 'five'],
            ['HELENA JOSEPH MAZIKU', 'FPCT ZIBA', 'F', 'five'],
            ['CHRISTINA EMANUEL MAZIKU', 'FPCT ZIBA', 'F', 'five'],
            ['ISACK SALUM SHIJA', 'FPCT ZIBA', 'M', 'five'],
            ['CHRISTINA EMANUEL TULO', 'FPCT ZIBA', 'F', 'five'],
            ['JOHN SAMUEL ANANIA', 'FPCT ZIBA', 'M', 'five'],
            ['MERINA EMANUEL KANYESU', 'FPCT ZIBA', 'F', 'five'],
            ['JUDITH BERNARD ISACK', 'FPCT ZIBA', 'F', 'five'],
            ['MARY YONA ISACK', 'FPCT ZIBA', 'F', 'five'],
            ['CAROLINE NJILE MAGESE', 'FPCT ZIBA', 'F', 'five'],

            ['LEAH EMMANUEL', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['MWATANO JOHNSON', 'MORAVIAN IGUNGA', 'M', 'commerce'],
            ['HELLEN BENJAMIN', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['ANNA DAUD', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['MARY LAZARO', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['NAOMI MOHAMED', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['ALEX FLUGENCE', 'MORAVIAN IGUNGA', 'M', 'commerce'],
            ['ELIZABETH KIULA', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['AGNESS IDD', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['AMINA SHEGA', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['LAMECK SIMON BILIA', 'MORAVIAN IGUNGA', 'M', 'commerce'],
            ['ASIMENYE RWITIKO', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['JOSHUA LAMECK NDEZI', 'MORAVIAN IGUNGA', 'M', 'commerce'],
            ['MARIAMU JUMA NGOI', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['ESTER BENARD MATEMBA', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['GRACE ADAM MBOJE', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['LUCIA STEVEN MTANI', 'MORAVIAN IGUNGA', 'F', 'commerce'],
            ['MERSIANA ANDREW', 'MORAVIAN IGUNGA', 'F', 'basic'],

            ['LINDA DAUDI MOHAMED', 'FPCT ELIMU', 'F', 'five'],
            ['MARIAM DAVID KAYUNI', 'FPCT ELIMU', 'F', 'five'],
            ['RICHARD ELIKANA NOGIGWE', 'FPCT ELIMU', 'M', 'five'],
            ['SUZANA MASANJA MASUMBUKO', 'FPCT ELIMU', 'F', 'five'],
            ['JOSEPH MASALU LIPHASI', 'FPCT ELIMU', 'M', 'five'],
            ['ISSA ABDALA SALUM', 'FPCT ELIMU', 'M', 'five'],
            ['RAHEL LAZARO EMMANUEL', 'FPCT ELIMU', 'F', 'five'],
            ['EGLA ISSAYA JUMA', 'FPCT ELIMU', 'F', 'five'],
            ['SIUZANA PETER SAMWEL', 'FPCT ELIMU', 'F', 'five'],
            ['PAUL MUSA JUMA', 'FPCT ELIMU', 'M', 'five'],
            ['SARA JEREMIA BENJAMIN', 'FPCT ELIMU', 'F', 'five'],
            ['SOMEBELITA MSHORANGA NKINGA', 'FPCT ELIMU', 'F', 'five'],
        ];

        $subjectIds = DB::table('form_two_subjects')
            ->where('education_level', 'secondary')
            ->whereNotIn('abbreviation', ['CIV', 'ICS', 'B/KP', 'B/KNW', 'LIT-ENG'])
            ->pluck('id', 'abbreviation');
        $usedStudentNumbers = DB::table('form_two_students')
            ->where('student_number', 'like', 'F2-%')
            ->pluck('student_number')
            ->flip();
        $nextNumber = 1;

        DB::transaction(function () use ($students, $subjectProfiles, $subjectIds, $usedStudentNumbers, &$nextNumber) {
            foreach ($students as [$candidateName, $fcpName, $sex, $profile]) {
                $studentId = DB::table('form_two_students')
                    ->where('education_level', 'secondary')
                    ->where('class_level', 'Form 2')
                    ->where('candidate_name', $candidateName)
                    ->where('fcp_name', $fcpName)
                    ->value('id');

                if (! $studentId) {
                    do {
                        $studentNumber = 'F2-'.str_pad((string) $nextNumber++, 3, '0', STR_PAD_LEFT);
                    } while (isset($usedStudentNumbers[$studentNumber]));

                    $usedStudentNumbers[$studentNumber] = true;
                    $studentId = DB::table('form_two_students')->insertGetId([
                        'student_number' => $studentNumber,
                        'candidate_name' => $candidateName,
                        'fcp_name' => $fcpName,
                        'sex' => $sex,
                        'education_level' => 'secondary',
                        'class_level' => 'Form 2',
                        'is_active' => true,
                        'created_by' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                foreach ($subjectProfiles[$profile] as $abbreviation) {
                    DB::table('form_two_student_subject')->updateOrInsert(
                        ['student_id' => $studentId, 'subject_id' => $subjectIds[$abbreviation]],
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
};
