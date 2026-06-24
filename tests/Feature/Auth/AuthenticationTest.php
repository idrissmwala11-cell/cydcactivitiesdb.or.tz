<?php

namespace Tests\Feature\Auth;

use App\Mail\LoginOtpMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response
            ->assertSessionHas('login_otp')
            ->assertRedirect(route('login.otp', absolute: false));
        Mail::assertSent(LoginOtpMail::class, fn ($mail) => $mail->hasTo($user->email));
    }

    public function test_previous_otp_still_works_after_resend(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $firstCode = Mail::sent(LoginOtpMail::class)->first()->code;

        $this->post(route('login.otp.resend'));

        Mail::assertSent(LoginOtpMail::class, 2);

        $response = $this->post(route('login.otp.verify'), [
            'code' => $firstCode,
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
    }

    public function test_resent_otp_works_after_resend(): void
    {
        Mail::fake();
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->post(route('login.otp.resend'));

        $secondCode = Mail::sent(LoginOtpMail::class)->last()->code;

        $response = $this->post(route('login.otp.verify'), [
            'code' => $secondCode,
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
