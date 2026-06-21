<?php

namespace Tests\Feature;

use App\Models\MasomoYaMtaala;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CenterSharedRecordsAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_with_the_same_center_id_can_view_each_others_program_day_records(): void
    {
        $creator = User::factory()->create([
            'center_id' => 'TZ069',
            'role' => 'user',
        ]);
        $sameCenterUser = User::factory()->create([
            'center_id' => ' tz069 ',
            'role' => 'user',
        ]);
        $otherCenterUser = User::factory()->create([
            'center_id' => 'TZ070',
            'role' => 'user',
        ]);

        $record = MasomoYaMtaala::create([
            'user_id' => $creator->id,
            'date' => '2026-06-21',
            'teacher' => 'Teacher Shared',
            'subject_type' => 'Mathematics',
            'age_group' => '12-14 years',
            'topic' => 'Shared Center Topic',
            'category' => 'kiakili',
            'status' => 'submitted',
        ]);

        $this->actingAs($sameCenterUser)
            ->get(route('submissions.masomo-ya-mtaala.index'))
            ->assertOk()
            ->assertSee('Shared Center Topic');

        $this->actingAs($sameCenterUser)
            ->get(route('submissions.masomo-ya-mtaala.show', $record))
            ->assertOk()
            ->assertSee('Shared Center Topic');

        $this->actingAs($otherCenterUser)
            ->get(route('submissions.masomo-ya-mtaala.index'))
            ->assertOk()
            ->assertDontSee('Shared Center Topic');

        $this->actingAs($otherCenterUser)
            ->get(route('submissions.masomo-ya-mtaala.show', $record))
            ->assertForbidden();
    }
}
