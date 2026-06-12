<?php

namespace App\Services;

use App\Models\FormTwoAssessment;
use App\Models\FormTwoStudent;

class FormTwoResultCalculator
{
    public function grade(?float $mark, float $maxMarks = 100): ?string
    {
        if ($mark === null || $maxMarks <= 0) {
            return null;
        }

        $percentage = ($mark / $maxMarks) * 100;

        return match (true) {
            $percentage >= 74.5 => 'A',
            $percentage >= 64.5 => 'B',
            $percentage >= 44.5 => 'C',
            $percentage >= 29.5 => 'D',
            default => 'F',
        };
    }

    public function gradePoint(?string $grade): ?int
    {
        return match ($grade) {
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 4,
            'F' => 5,
            default => null,
        };
    }

    public function division(array $points, bool $hasAnyMark = true): array
    {
        if (! $hasAnyMark) {
            return ['division' => 'ABS', 'points' => null];
        }

        sort($points);
        $bestSeven = array_slice($points, 0, 7);

        if (count($bestSeven) < 7) {
            return ['division' => 'INC', 'points' => array_sum($bestSeven) ?: null];
        }

        $total = array_sum($bestSeven);
        $division = match (true) {
            $total < 18 => 'I',
            $total < 22 => 'II',
            $total < 26 => 'III',
            $total < 34 => 'IV',
            default => '0',
        };

        return ['division' => $division, 'points' => $total];
    }

    public function summary(FormTwoStudent $student, FormTwoAssessment $assessment): array
    {
        $marks = $student->marks->where('assessment_id', $assessment->id)->keyBy('subject_id');
        $subjectRows = [];
        $numericMarks = [];
        $points = [];

        foreach ($student->subjects->where('pivot.registered', true) as $subject) {
            $markRecord = $marks->get($subject->id);
            $isAbsent = (bool) ($markRecord?->is_absent);
            $mark = $isAbsent || $markRecord?->mark === null ? null : (float) $markRecord->mark;
            $grade = $isAbsent ? 'ABS' : $this->grade($mark, (float) $assessment->max_marks);
            $point = $this->gradePoint($grade);

            if ($mark !== null) {
                $numericMarks[] = $mark;
            }

            if ($point !== null) {
                $points[] = $point;
            }

            $subjectRows[] = compact('subject', 'mark', 'grade', 'point', 'isAbsent');
        }

        $average = count($numericMarks) ? round(array_sum($numericMarks) / count($numericMarks), 2) : null;
        $division = $student->education_level === 'primary'
            ? ['division' => null, 'points' => null]
            : $this->division($points, count($numericMarks) > 0);

        return [
            'student' => $student,
            'subjects' => $subjectRows,
            'total' => round(array_sum($numericMarks), 2),
            'average' => $average,
            'overall_grade' => $this->grade($average, (float) $assessment->max_marks),
            'division' => $division['division'],
            'points' => $division['points'],
            'sat_subjects' => count($numericMarks),
            'registered_subjects' => count($subjectRows),
            'rank' => null,
        ];
    }
}
