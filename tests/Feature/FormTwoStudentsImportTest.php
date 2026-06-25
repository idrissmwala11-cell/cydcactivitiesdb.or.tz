<?php

namespace Tests\Feature;

use App\Models\FormTwoStudent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FormTwoStudentsImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_named_form_two_rows_are_imported_with_fcp_gender_and_subjects(): void
    {
        $students = FormTwoStudent::query()
            ->where('education_level', 'secondary')
            ->where('class_level', 'Form 2');

        $this->assertSame(121, (clone $students)->count());
        $this->assertSame(78, (clone $students)->where('sex', 'F')->count());
        $this->assertSame(43, (clone $students)->where('sex', 'M')->count());

        $expectedFcpCounts = [
            'EAGT URAMBO' => 9,
            'USSOKE' => 24,
            'FPCT URAMBO' => 14,
            'EAGT MWANZUGI' => 7,
            'T.A.G ITOBO' => 8,
            'IPILILI' => 19,
            'FPCT ZIBA' => 10,
            'MORAVIAN IGUNGA' => 18,
            'FPCT ELIMU' => 12,
        ];

        foreach ($expectedFcpCounts as $fcpName => $count) {
            $this->assertSame($count, (clone $students)->where('fcp_name', $fcpName)->count());
        }

        foreach (['TAZENGWA', 'USHIRIKA', 'NYASA'] as $blankFcp) {
            $this->assertSame(0, (clone $students)->where('fcp_name', $blankFcp)->count());
        }

        $duplicates = DB::table('form_two_students')
            ->select('candidate_name', 'fcp_name')
            ->where('education_level', 'secondary')
            ->where('class_level', 'Form 2')
            ->groupBy('candidate_name', 'fcp_name')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $this->assertSame(0, $duplicates);

        $this->assertSame(
            10,
            FormTwoStudent::where('candidate_name', 'EMMMANUEL ELIAS EMMANUEL')
                ->firstOrFail()
                ->subjects()
                ->count()
        );
        $this->assertSame(
            5,
            FormTwoStudent::where('candidate_name', 'ANDREA YUDA')
                ->firstOrFail()
                ->subjects()
                ->count()
        );

        $removedSubjects = ['CIV', 'ICS', 'B/KP', 'B/KNW', 'LIT-ENG'];
        $studentsWithRemovedSubjects = (clone $students)
            ->whereHas('subjects', fn ($query) => $query->whereIn('abbreviation', $removedSubjects))
            ->count();

        $this->assertSame(0, $studentsWithRemovedSubjects);
    }
}
