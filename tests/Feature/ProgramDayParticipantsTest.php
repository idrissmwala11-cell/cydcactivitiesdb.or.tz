<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramDayParticipantsTest extends TestCase
{
    use RefreshDatabase;

    public function test_curriculum_studies_saves_present_and_absent_participants(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('submissions.masomo-ya-mtaala.store'), [
                'date' => '2026-06-21',
                'jina_la_mwalimu' => 'Teacher One',
                'somo_analofundisha' => 'Mathematics',
                'category' => 'kiakili',
                'darasa_la_mjaka_mingapi' => '12-14 years',
                'mada_aliyo_fundisha' => 'Fractions',
                'maoni_ya_mwanafunzi' => 'Good lesson',
                'maoni_ya_mwalimu' => 'Participated well',
                'present_participants' => "TZ001 - Asha Juma\nTZ002 - Baraka Musa",
                'absent_participants' => 'TZ003 - Neema Paulo',
                'action' => 'submit',
            ])
            ->assertRedirect(route('submissions.masomo-ya-mtaala.index'));

        $this->assertDatabaseHas('masomo_ya_mtaala', [
            'user_id' => $user->id,
            'present_participants' => "TZ001 - Asha Juma\nTZ002 - Baraka Musa",
            'absent_participants' => 'TZ003 - Neema Paulo',
        ]);
    }

    public function test_vocational_subjects_save_present_and_absent_participants(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('submissions.masomo-ya-fani.store'), [
                'date' => '2026-06-21',
                'teacher' => 'Instructor One',
                'fani_type' => 'Tailoring',
                'topic' => 'Stitching',
                'student_preferences' => 'Practical work',
                'student_feedback' => 'Useful',
                'teacher_feedback' => 'Needs practice',
                'present_participants' => 'TZ010 - Peter John',
                'absent_participants' => 'TZ011 - Mary Simon',
                'status' => 'submitted',
            ])
            ->assertRedirect(route('submissions.masomo-ya-fani.index'));

        $this->assertDatabaseHas('masomo_ya_fani', [
            'user_id' => $user->id,
            'present_participants' => 'TZ010 - Peter John',
            'absent_participants' => 'TZ011 - Mary Simon',
        ]);
    }

    public function test_special_program_saves_present_and_absent_participants(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('submissions.special-program.store'), [
                'date' => '2026-06-21',
                'teacher' => 'Facilitator One',
                'topic' => 'Health Session',
                'age_range' => '15-17 years',
                'teacher_feedback' => 'Strong attendance',
                'supervisor_feedback' => 'Good session',
                'present_participants' => 'TZ020 - Halima Said',
                'absent_participants' => 'TZ021 - Musa Ally',
            ])
            ->assertRedirect(route('submissions.special-program.index'));

        $this->assertDatabaseHas('special_programs', [
            'user_id' => $user->id,
            'present_participants' => 'TZ020 - Halima Said',
            'absent_participants' => 'TZ021 - Musa Ally',
        ]);
    }
}
