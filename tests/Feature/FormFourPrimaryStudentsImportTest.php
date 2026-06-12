<?php

namespace Tests\Feature;

use App\Models\FormTwoStudent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FormFourPrimaryStudentsImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_named_standard_four_rows_are_imported_with_gender_fcp_and_primary_subjects(): void
    {
        $students = FormTwoStudent::query()
            ->where('education_level', 'primary')
            ->where('class_level', 'Darasa la Nne');

        $this->assertSame(29, (clone $students)->count());
        $this->assertSame(10, (clone $students)->where('sex', 'F')->count());
        $this->assertSame(19, (clone $students)->where('sex', 'M')->count());

        $expectedFcpCounts = [
            'USSOKE' => 1,
            'FPCT URAMBO' => 3,
            'T.A.G ITOBO' => 14,
            'IPILILI' => 2,
            'FPCT ZIBA' => 7,
            'MORAVIAN IGUNGA' => 2,
        ];

        foreach ($expectedFcpCounts as $fcpName => $count) {
            $this->assertSame($count, (clone $students)->where('fcp_name', $fcpName)->count());
        }

        foreach (['TAZENGWA', 'USHIRIKA'] as $blankFcp) {
            $this->assertSame(0, (clone $students)->where('fcp_name', $blankFcp)->count());
        }

        $duplicates = DB::table('form_two_students')
            ->select('candidate_name', 'fcp_name')
            ->where('education_level', 'primary')
            ->where('class_level', 'Darasa la Nne')
            ->groupBy('candidate_name', 'fcp_name')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $this->assertSame(0, $duplicates);

        $incorrectSubjectCounts = (clone $students)
            ->withCount('subjects')
            ->get()
            ->where('subjects_count', '!=', 6);

        $this->assertCount(0, $incorrectSubjectCounts);
    }
}
