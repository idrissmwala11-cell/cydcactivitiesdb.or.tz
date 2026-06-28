<?php

namespace Tests\Feature;

use App\Mail\PublishedResultsMail;
use App\Models\FormTwoAssessment;
use App\Models\FormTwoMark;
use App\Models\FormTwoStudent;
use App\Models\FormTwoSubject;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class FormTwoResultsSharingTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_publish_results_for_read_only_access_by_all_users(): void
    {
        Mail::fake();
        config()->set('center_data_reports.primary_admin_email', 'ekawira@tz.ci.org');
        config()->set('center_data_reports.secondary_admin_email', 'idrissmwala11@gmail.com');

        $creator = User::factory()->create(['role' => 'admin']);
        $publisher = User::factory()->create([
            'email' => 'snashon.tz0827@gmail.com',
            'role' => 'user',
        ]);
        $resultsEditor = User::factory()->create([
            'email' => 'amasele.tz0844@gmail.com',
            'role' => 'user',
        ]);
        $viewer = User::factory()->create(['role' => 'user']);
        $subject = FormTwoSubject::where('education_level', 'secondary')
            ->where('abbreviation', 'B/MATH')
            ->firstOrFail();
        $assessment = FormTwoAssessment::create([
            'name' => 'Published Test',
            'slug' => 'published-test',
            'term' => 'TERM I',
            'assessment_date' => '2026-06-22',
            'max_marks' => 100,
            'display_order' => 101,
            'is_published' => false,
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
        ]);
        $student = FormTwoStudent::create([
            'student_number' => 'F2-PUBLISH-TEST',
            'candidate_name' => 'PUBLISHED STUDENT',
            'fcp_name' => 'FCP PUBLISH',
            'sex' => 'M',
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
            'mark' => 76,
            'is_absent' => false,
            'recorded_by' => $publisher->id,
        ]);

        $query = [
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
            'assessment_id' => $assessment->id,
        ];

        $this->actingAs($viewer)
            ->get(route('form-two-results.results.index', $query))
            ->assertForbidden();
        $this->actingAs($viewer)
            ->post(route('form-two-results.reports.publish', $assessment))
            ->assertForbidden();
        $this->actingAs($resultsEditor)
            ->get(route('form-two-results.reports.index', $query))
            ->assertOk()
            ->assertDontSee('Publish Results');
        $this->actingAs($resultsEditor)
            ->post(route('form-two-results.reports.publish', $assessment))
            ->assertForbidden();

        $this->actingAs($publisher)
            ->post(route('form-two-results.reports.publish', $assessment))
            ->assertRedirect();

        $this->assertTrue($assessment->fresh()->is_published);
        Mail::assertSent(PublishedResultsMail::class, function (PublishedResultsMail $mail) use ($publisher, $resultsEditor, $viewer, $assessment) {
            $to = collect($mail->to)->pluck('address')->all();

            return $to[0] === 'ekawira@tz.ci.org'
                && $to[1] === 'idrissmwala11@gmail.com'
                && in_array($publisher->email, $to, true)
                && in_array($resultsEditor->email, $to, true)
                && in_array($viewer->email, $to, true)
                && $mail->assessment->is($assessment);
        });

        $this->actingAs($viewer)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('View Results List');

        $this->actingAs($viewer)
            ->get(route('published-results.index', $query))
            ->assertOk()
            ->assertSee('PUBLISHED RESULTS')
            ->assertSee('logos/church-logo-1.jpeg')
            ->assertSee('logos/church-logo-2.jpeg')
            ->assertSee('Group')
            ->assertSee('PASS %')
            ->assertSee('PUBLISHED STUDENT')
            ->assertSee('76-A')
            ->assertDontSee('Marks Entry')
            ->assertDontSee('Publish Results');

        $download = $this->actingAs($viewer)->get(route('published-results.download', $query));
        $download->assertOk();
        $this->assertStringContainsString('application/pdf', (string) $download->headers->get('content-type'));
        $this->assertStringContainsString('.pdf', (string) $download->headers->get('content-disposition'));
        $downloadedContent = $download->streamedContent();
        $this->assertStringStartsWith('%PDF', $downloadedContent);

        $this->actingAs($resultsEditor)
            ->delete(route('form-two-results.reports.unpublish', $assessment))
            ->assertForbidden();
        $this->actingAs($resultsEditor)
            ->delete(route('form-two-results.assessments.destroy', $assessment))
            ->assertForbidden();
        $this->actingAs($publisher)
            ->delete(route('form-two-results.reports.unpublish', $assessment))
            ->assertRedirect();

        $this->assertFalse($assessment->fresh()->is_published);
        $this->actingAs($viewer)
            ->get(route('published-results.index', $query))
            ->assertNotFound();
    }

    public function test_full_results_list_is_ordered_by_position_with_absent_students_last(): void
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
            'name' => 'Position Test',
            'slug' => 'position-test',
            'term' => 'TERM I',
            'assessment_date' => '2026-06-22',
            'max_marks' => 100,
            'display_order' => 100,
            'is_published' => true,
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
        ]);

        $students = collect([
            ['F2-TEST-LOW', 'LOW STUDENT', 45],
            ['F2-TEST-ABS', 'ABS STUDENT', null],
            ['F2-TEST-HIGH', 'HIGH STUDENT', 85],
        ])->map(function (array $data) use ($creator, $subject, $assessment) {
            $student = FormTwoStudent::create([
                'student_number' => $data[0],
                'candidate_name' => $data[1],
                'fcp_name' => 'FCP TEST',
                'sex' => 'F',
                'education_level' => 'secondary',
                'class_level' => 'Form 2',
                'is_active' => true,
                'created_by' => $creator->id,
            ]);
            $student->subjects()->attach($subject->id, ['registered' => true]);

            if ($data[2] !== null) {
                FormTwoMark::create([
                    'assessment_id' => $assessment->id,
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'mark' => $data[2],
                    'is_absent' => false,
                    'recorded_by' => $creator->id,
                ]);
            }

            return $student;
        });

        $response = $this->actingAs($viewer)->get(route('form-two-results.reports.index', [
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
            'assessment_id' => $assessment->id,
            'report_type' => 'list',
            'run' => 1,
        ]));

        $response->assertOk()
            ->assertSee('FULL RESULTS LIST')
            ->assertSeeInOrder(['HIGH STUDENT', 'LOW STUDENT', 'ABS STUDENT'])
            ->assertSee('B/MATH')
            ->assertSee('85-A');

        $this->actingAs($viewer)->get(route('form-two-results.results.index', [
            'education_level' => 'secondary',
            'class_level' => 'Form 2',
            'assessment_id' => $assessment->id,
        ]))
            ->assertOk()
            ->assertSeeInOrder(['HIGH STUDENT', 'LOW STUDENT', 'ABS STUDENT']);

        $this->assertCount(3, $students);
    }

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
        $unselectedSubject = FormTwoSubject::where('education_level', 'secondary')
            ->where('abbreviation', 'COMM')
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

        $marks = $this->actingAs($viewer)->get(route('form-two-results.marks.index', $query));
        $marks->assertOk();
        $marksHtml = $marks->getContent();
        preg_match('/<tr data-student-row="'.$student->id.'".*?<\/tr>/s', $marksHtml, $studentRowMatch);
        $studentRow = $studentRowMatch[0] ?? '';

        $this->assertNotSame('', $studentRow, 'Student row must be rendered in Marks Entry.');
        $this->assertTrue(str_contains($studentRow, 'FCP URAMBO'), 'Marks Entry must display the student FCP name.');
        $this->assertTrue(str_contains($studentRow, $subject->abbreviation), 'Marks Entry must display the selected subject.');
        $this->assertTrue(str_contains($studentRow, 'data-subject="'.$subject->id.'"'), 'Selected subject must have a marks input.');
        $this->assertFalse(str_contains($studentRow, 'data-subject="'.$unselectedSubject->id.'"'), 'Unselected subject must not have a marks input for this student.');
        $this->assertFalse(str_contains($studentRow, '>N/R<'), 'Marks Entry must not display N/R subject cells.');

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
