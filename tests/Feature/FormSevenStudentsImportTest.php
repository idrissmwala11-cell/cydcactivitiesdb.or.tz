<?php

namespace Tests\Feature;

use App\Models\FormTwoStudent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FormSevenStudentsImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_named_standard_seven_rows_are_imported_with_gender_fcp_and_primary_subjects(): void
    {
        $students = FormTwoStudent::query()
            ->where('education_level', 'primary')
            ->where('class_level', 'Darasa la Saba');

        $this->assertSame(213, (clone $students)->count());
        $this->assertSame(119, (clone $students)->where('sex', 'F')->count());
        $this->assertSame(94, (clone $students)->where('sex', 'M')->count());

        $expectedFcpCounts = [
            'EAGT URAMBO' => 2,
            'FPCT ELIMU' => 20,
            'FPCT URAMBO' => 11,
            'FPCT ZIBA' => 30,
            'IPILILI' => 33,
            'MORAVIAN IGUNGA' => 28,
            'MWANZUGI' => 49,
            'T.A.G ITOBO' => 28,
            'USSOKE' => 12,
        ];

        foreach ($expectedFcpCounts as $fcpName => $count) {
            $this->assertSame($count, (clone $students)->where('fcp_name', $fcpName)->count());
        }

        $duplicates = DB::table('form_two_students')
            ->select('candidate_name', 'fcp_name')
            ->where('education_level', 'primary')
            ->where('class_level', 'Darasa la Saba')
            ->groupBy('candidate_name', 'fcp_name')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $this->assertSame(0, $duplicates);

        $incorrectSubjectCounts = (clone $students)
            ->withCount('subjects')
            ->get()
            ->where('subjects_count', '!=', 6);

        $this->assertCount(0, $incorrectSubjectCounts);
        $this->assertSame(
            ['HIS', 'KING', 'KISW', 'MAJ', 'SAY', 'URA'],
            FormTwoStudent::where('candidate_name', 'EMMANUEL KASELE')
                ->firstOrFail()
                ->subjects()
                ->pluck('abbreviation')
                ->sort()
                ->values()
                ->all()
        );
    }
}
