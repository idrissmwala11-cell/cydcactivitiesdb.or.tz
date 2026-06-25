<?php

namespace Tests\Feature;

use App\Models\FormTwoStudent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FormFourStudentsImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_four_students_are_imported_once_with_gender_fcp_and_subjects(): void
    {
        $students = FormTwoStudent::query()
            ->where('education_level', 'secondary')
            ->where('class_level', 'Form 4');

        $this->assertSame(42, (clone $students)->count());
        $this->assertSame(20, (clone $students)->where('sex', 'F')->count());
        $this->assertSame(22, (clone $students)->where('sex', 'M')->count());

        $this->assertSame(12, (clone $students)->where('fcp_name', 'MORAVIAN USSOKE')->count());
        $this->assertSame(20, (clone $students)->where('fcp_name', 'EAGT URAMBO')->count());
        $this->assertSame(10, (clone $students)->where('fcp_name', 'FPCT URAMBO')->count());

        $duplicates = DB::table('form_two_students')
            ->select('candidate_name', 'fcp_name')
            ->where('education_level', 'secondary')
            ->where('class_level', 'Form 4')
            ->groupBy('candidate_name', 'fcp_name')
            ->havingRaw('COUNT(*) > 1')
            ->count();

        $this->assertSame(0, $duplicates);

        $studentsWithIncorrectSubjectCount = (clone $students)
            ->withCount('subjects')
            ->get()
            ->where('subjects_count', '!=', 9);

        $this->assertCount(0, $studentsWithIncorrectSubjectCount);

        $removedSubjects = ['HTM', 'ICS', 'COMM', 'B/KP', 'B/KNW', 'LIT-ENG'];
        $studentsWithRemovedSubjects = (clone $students)
            ->whereHas('subjects', fn ($query) => $query->whereIn('abbreviation', $removedSubjects))
            ->count();

        $this->assertSame(0, $studentsWithRemovedSubjects);
    }
}
