<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserOnlineStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_request_marks_user_as_online(): void
    {
        $user = User::factory()->create([
            'last_seen_at' => null,
        ]);

        $this
            ->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();

        $user->refresh();

        $this->assertNotNull($user->last_seen_at);
        $this->assertTrue($user->is_online);
    }

    public function test_user_is_offline_after_five_minutes_without_activity(): void
    {
        $user = User::factory()->create([
            'last_seen_at' => now()->subMinutes(6),
        ]);

        $this->assertFalse($user->is_online);
    }
}
