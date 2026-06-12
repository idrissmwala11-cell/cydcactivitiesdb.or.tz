<?php

namespace Tests\Feature;

use App\Models\FormTwoAssessment;
use App\Models\FormTwoMark;
use App\Models\FormTwoStudent;
use App\Models\FormTwoSubject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormTwoResultsSharingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_users_share_results_and_can_run_reports(): void
    {
        $creator = User::factory()->create(['role' => 'admin']);
        $viewer = User::factory()->create([
            'email' => 'snashon.tz0827@gmail.com',
            'role' => 'user',
        ]);
        $subject = FormTwoSubject::where('education_level', 'secondary')
            ->where('abbreviation', 'B/MATH')
            ->firstOrFail();
        $assessment = FormTwoAssessment::create([
            'name' => 'Shared Test',
            'slug' => 'shared-test',
            'term' => 'TERM I',
            'assessment_date' => '2026-06-12',
            'max_marks' => 100,
            'display_order' => 99,
            'is_published' => true,
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
        ]);
        $student = FormTwoStudent::create([
            'student_number' => 'F2-SHARED',
            'candidate_name' => 'SHARED STUDENT',
            'fcp_name' => 'FCP URAMBO',
            'sex' => 'F',
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
            'is_active' => true,
            'created_by' => $creator->id,
        ]);
        $student->subjects()->attach($subject->id, ['registered' => true]);
        FormTwoMark::create([
            'assessment_id' => $assessment->id,
            'student_id' => $student->id,
            'subject_id' => $subject->id,
            'mark' => 80,
            'is_absent' => false,
            'recorded_by' => $creator->id,
        ]);

        $query = [
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
            'assessment_id' => $assessment->id,
        ];

        $results = $this->actingAs($viewer)->get(route('form-two-results.results.index', $query));
        $results->assertOk()
            ->assertSee('SHARED STUDENT')
            ->assertSee('B/MATH')
            ->assertSee('80-A')
            ->assertDontSee('<th>Grade</th>', false);

        $this->actingAs($viewer)
            ->get(route('form-two-results.reports.show', [$student, 'assessment_id' => $assessment->id]))
            ->assertOk()
            ->assertSee('1 kati ya 1')
            ->assertDontSee('fpct-logo.png')
            ->assertDontSee('ruo-school-logo.png');

        $this->actingAs($viewer)
            ->get(route('form-two-results.reports.index', $query + ['run' => 1, 'fcp_name' => 'FCP URAMBO']))
            ->assertOk()
            ->assertSee('SHARED STUDENT')
            ->assertSee('1 kati ya 1');
    }
}
