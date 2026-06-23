<?php

namespace Tests\Feature\Auth;

use App\Mail\UserApprovedMail;
use App\Mail\UserRegisteredForApprovalMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'phone' => '0712345678',
            'center_id' => 'TZ000000001',
            'cluster_name' => 'Urambo',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_admins_are_emailed_when_a_new_user_registers(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'role' => 'admin',
            'status' => 'approved',
        ]);

        $this->post('/register', [
            'email' => 'newuser@example.com',
            'phone' => '0712345679',
            'center_id' => 'TZ123456789',
            'cluster_name' => 'Urambo',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        Mail::assertSent(UserRegisteredForApprovalMail::class, function (UserRegisteredForApprovalMail $mail) use ($admin) {
            return $mail->hasTo($admin->email)
                && $mail->user->email === 'newuser@example.com'
                && $mail->user->status === 'pending';
        });
    }

    public function test_user_is_emailed_after_admin_approval(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'approved',
        ]);

        $user = User::factory()->create([
            'email' => 'pending@example.com',
            'status' => 'pending',
        ]);

        $response = $this
            ->actingAs($admin)
            ->patch(route('admin.users.approve', $user));

        $response->assertRedirect();

        Mail::assertSent(UserApprovedMail::class, function (UserApprovedMail $mail) use ($user) {
            return $mail->hasTo($user->email)
                && $mail->user->is($user);
        });

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'status' => 'approved',
            'approved_by' => $admin->id,
        ]);
    }
}
