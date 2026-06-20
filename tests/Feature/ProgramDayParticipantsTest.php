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
                'participant_roster_text' => "TZ001 - Asha Juma\nTZ002 - Baraka Musa\nTZ003 - Neema Paulo",
                'attendance_marker' => '1',
                'present_participant_numbers' => ['TZ001', 'TZ002'],
                'action' => 'submit',
            ])
            ->assertRedirect(route('submissions.masomo-ya-mtaala.index'));

        $this->assertDatabaseHas('masomo_ya_mtaala', [
            'user_id' => $user->id,
            'present_participants' => "TZ001 - Asha Juma\nTZ002 - Baraka Musa",
            'absent_participants' => 'TZ003 - Neema Paulo',
            'present_count' => 2,
            'absent_count' => 1,
        ]);

        $this->assertDatabaseHas('program_day_participants', [
            'user_id' => $user->id,
            'participant_number' => 'TZ003',
            'participant_name' => 'Neema Paulo',
            'is_active' => true,
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
                'participant_roster_text' => "TZ010 - Peter John\nTZ011 - Mary Simon",
                'attendance_marker' => '1',
                'present_participant_numbers' => ['TZ010'],
                'status' => 'submitted',
            ])
            ->assertRedirect(route('submissions.masomo-ya-fani.index'));

        $this->assertDatabaseHas('masomo_ya_fani', [
            'user_id' => $user->id,
            'present_participants' => 'TZ010 - Peter John',
            'absent_participants' => 'TZ011 - Mary Simon',
            'present_count' => 1,
            'absent_count' => 1,
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
                'participant_roster_text' => "TZ020 - Halima Said\nTZ021 - Musa Ally",
                'attendance_marker' => '1',
                'present_participant_numbers' => ['TZ020'],
            ])
            ->assertRedirect(route('submissions.special-program.index'));

        $this->assertDatabaseHas('special_programs', [
            'user_id' => $user->id,
            'present_participants' => 'TZ020 - Halima Said',
            'absent_participants' => 'TZ021 - Musa Ally',
            'present_count' => 1,
            'absent_count' => 1,
        ]);
    }

    public function test_saved_roster_can_be_reused_on_the_next_program_day_submission(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('submissions.special-program.store'), [
                'date' => '2026-06-21',
                'teacher' => 'Facilitator One',
                'topic' => 'First Session',
                'age_range' => '15-17 years',
                'participant_roster_text' => "TZ030 - John Pius\nTZ031 - Esther John",
                'attendance_marker' => '1',
                'present_participant_numbers' => ['TZ030', 'TZ031'],
            ]);

        $this->actingAs($user)
            ->post(route('submissions.masomo-ya-fani.store'), [
                'date' => '2026-06-22',
                'teacher' => 'Instructor One',
                'fani_type' => 'Tailoring',
                'topic' => 'Second Session',
                'attendance_marker' => '1',
                'present_participant_numbers' => ['TZ030'],
                'status' => 'submitted',
            ])
            ->assertRedirect(route('submissions.masomo-ya-fani.index'));

        $this->assertDatabaseHas('masomo_ya_fani', [
            'user_id' => $user->id,
            'present_participants' => 'TZ030 - John Pius',
            'absent_participants' => 'TZ031 - Esther John',
            'present_count' => 1,
            'absent_count' => 1,
        ]);
    }
}
