<?php

namespace Tests\Unit;

use App\Models\FormTwoAssessment;
use App\Models\FormTwoMark;
use App\Models\FormTwoStudent;
use App\Models\FormTwoSubject;
use App\Services\FormTwoResultCalculator;
use Illuminate\Database\Eloquent\Relations\Pivot;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FormTwoResultCalculatorTest extends TestCase
{
    #[DataProvider('gradeCases')]
    public function test_it_matches_the_workbook_grade_boundaries(float $mark, string $expected): void
    {
        $this->assertSame($expected, (new FormTwoResultCalculator)->grade($mark));
    }

    public static function gradeCases(): array
    {
        return [
            [100, 'A'], [74.5, 'A'], [74.49, 'B'], [64.5, 'B'],
            [64.49, 'C'], [44.5, 'C'], [44.49, 'D'], [29.5, 'D'], [29.49, 'F'],
        ];
    }

    public function test_primary_grade_boundaries_use_the_fifty_mark_scale(): void
    {
        $calculator = new FormTwoResultCalculator;

        $this->assertSame('A', $calculator->grade(50, 50, true));
        $this->assertSame('A', $calculator->grade(41, 50, true));
        $this->assertSame('B', $calculator->grade(40, 50, true));
        $this->assertSame('B', $calculator->grade(31, 50, true));
        $this->assertSame('C', $calculator->grade(30, 50, true));
        $this->assertSame('C', $calculator->grade(21, 50, true));
        $this->assertSame('D', $calculator->grade(20, 50, true));
        $this->assertSame('D', $calculator->grade(11, 50, true));
        $this->assertSame('E', $calculator->grade(10, 50, true));
        $this->assertSame('E', $calculator->grade(0, 50, true));
    }

    public function test_it_uses_the_best_seven_subject_points_for_division(): void
    {
        $result = (new FormTwoResultCalculator)->division([5, 4, 1, 1, 2, 2, 3, 5, 1]);

        $this->assertSame(14, $result['points']);
        $this->assertSame('I', $result['division']);
    }

    public function test_it_marks_incomplete_and_absent_results(): void
    {
        $calculator = new FormTwoResultCalculator;

        $this->assertSame('INC', $calculator->division([1, 2, 3], true)['division']);
        $this->assertSame('ABS', $calculator->division([], false)['division']);
    }

    public function test_primary_results_use_grade_without_division_or_points(): void
    {
        $subject = (new FormTwoSubject)->forceFill(['id' => 1, 'name' => 'KISWAHILI']);
        $subject->setRelation('pivot', (new Pivot)->forceFill(['registered' => true]));

        $student = (new FormTwoStudent)->forceFill(['id' => 1, 'education_level' => 'primary']);
        $student->setRelation('subjects', collect([$subject]));
        $student->setRelation('marks', collect([
            (new FormTwoMark)->forceFill([
                'assessment_id' => 1,
                'subject_id' => 1,
                'mark' => 41,
                'is_absent' => false,
            ]),
        ]));

        $assessment = (new FormTwoAssessment)->forceFill(['id' => 1, 'max_marks' => 50]);
        $summary = (new FormTwoResultCalculator)->summary($student, $assessment);

        $this->assertSame('A', $summary['overall_grade']);
        $this->assertNull($summary['division']);
        $this->assertNull($summary['points']);
    }
}
