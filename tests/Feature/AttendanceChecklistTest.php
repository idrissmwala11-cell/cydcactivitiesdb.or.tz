<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AttendanceChecklistTest extends TestCase
{
    use RefreshDatabase;

    public function test_talent_attendance_saves_present_and_absent_participants_from_checklist(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('talent-attendance.store'), [
                'date' => '2026-07-05',
                'instructor_name' => 'Teacher One',
                'talent_taught' => 'Singing',
                'lesson_topic' => 'Voice control',
                'participants' => [
                    ['participant_name' => 'Asha John', 'participant_number' => 'TZ001', 'status' => 'present'],
                    ['participant_name' => 'Musa Peter', 'participant_number' => 'TZ002', 'status' => 'present'],
                    ['participant_name' => 'Rehema Paulo', 'participant_number' => 'TZ003', 'status' => 'absent'],
                ],
            ])
            ->assertRedirect(route('talent-attendance.index'));

        $this->assertDatabaseHas('talent_attendance', [
            'user_id' => $user->id,
            'attendance_count' => 3,
        ]);

        $this->assertDatabaseHas('talent_absent_participants', [
            'participant_name' => 'Asha John',
            'participant_number' => 'TZ001',
            'status' => 'present',
        ]);

        $this->assertDatabaseHas('talent_absent_participants', [
            'participant_name' => 'Rehema Paulo',
            'participant_number' => 'TZ003',
            'status' => 'absent',
        ]);
    }

    public function test_skills_attendance_calculates_present_count_and_saves_statuses(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('skills-attendance.store'), [
                'date' => '2026-07-05',
                'teacher_name' => 'Teacher Two',
                'lesson_topic' => 'Computer basics',
                'lesson_topic_details' => 'Keyboard practice',
                'participants' => [
                    ['participant_name' => 'Asha John', 'participant_number' => 'TZ001', 'status' => 'present'],
                    ['participant_name' => 'Musa Peter', 'participant_number' => 'TZ002', 'status' => 'present'],
                    ['participant_name' => 'Rehema Paulo', 'participant_number' => 'TZ003', 'status' => 'absent'],
                ],
            ])
            ->assertRedirect(route('skills-attendance.index'));

        $this->assertDatabaseHas('skills_attendance', [
            'user_id' => $user->id,
            'present_count' => 2,
        ]);

        $this->assertDatabaseHas('absent_participants', [
            'participant_name' => 'Musa Peter',
            'participant_number' => 'TZ002',
            'status' => 'present',
            'attendance_type' => 'skills',
        ]);

        $this->assertDatabaseHas('absent_participants', [
            'participant_name' => 'Rehema Paulo',
            'participant_number' => 'TZ003',
            'status' => 'absent',
            'attendance_type' => 'skills',
        ]);
    }

    public function test_curriculum_attendance_calculates_attendees_and_saves_statuses(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('curriculum-attendance.store'), [
                'tarehe' => '2026-07-05',
                'jina_la_mwalimu' => 'Teacher Three',
                'somo' => 'Mathematics',
                'mada' => 'Fractions',
                'participants' => [
                    ['participant_name' => 'Asha John', 'participant_number' => 'TZ001', 'status' => 'present'],
                    ['participant_name' => 'Musa Peter', 'participant_number' => 'TZ002', 'status' => 'present'],
                    ['participant_name' => 'Rehema Paulo', 'participant_number' => 'TZ003', 'status' => 'absent'],
                ],
            ])
            ->assertRedirect(route('curriculum-attendance.index'));

        $this->assertDatabaseHas('curriculum_attendance', [
            'user_id' => $user->id,
            'wahudhuria' => 2,
        ]);

        $this->assertDatabaseHas('curriculum_attendance_participants', [
            'participant_name' => 'Asha John',
            'participant_number' => 'TZ001',
            'status' => 'present',
        ]);

        $this->assertDatabaseHas('curriculum_attendance_participants', [
            'participant_name' => 'Rehema Paulo',
            'participant_number' => 'TZ003',
            'status' => 'absent',
        ]);
    }
}
