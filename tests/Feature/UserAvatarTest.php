<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_view_a_profile_photo(): void
    {
        Storage::fake('public');

        $viewer = User::factory()->create();
        $profileUser = User::factory()->create([
            'profile_photo' => 'profile.jpg',
        ]);

        Storage::disk('public')->put('profile_photos/profile.jpg', 'profile photo');

        $response = $this
            ->actingAs($viewer)
            ->get(route('users.avatar', $profileUser));

        $response->assertOk();
        $this->assertStringContainsString('private', (string) $response->headers->get('Cache-Control'));
    }

    public function test_guest_cannot_view_a_profile_photo(): void
    {
        Storage::fake('public');

        $profileUser = User::factory()->create([
            'profile_photo' => 'profile.jpg',
        ]);

        Storage::disk('public')->put('profile_photos/profile.jpg', 'profile photo');

        $this->get(route('users.avatar', $profileUser))
            ->assertRedirect(route('login'));
    }

    public function test_missing_profile_photo_returns_not_found(): void
    {
        Storage::fake('public');

        $viewer = User::factory()->create();
        $profileUser = User::factory()->create([
            'profile_photo' => 'missing.jpg',
        ]);

        $this
            ->actingAs($viewer)
            ->get(route('users.avatar', $profileUser))
            ->assertNotFound();
    }
}
