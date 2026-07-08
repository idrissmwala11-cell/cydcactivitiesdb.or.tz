<?php

namespace Tests\Feature;

use App\Models\SmsLog;
use App\Models\User;
use App\Services\SmsSender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdminSmsGatewayTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_sms_gateway_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->create([
            'role' => 'user',
            'status' => 'approved',
            'phone' => '0673746031',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.sms-gateway.index'))
            ->assertOk()
            ->assertSee('SMS Gateway')
            ->assertSee('SMS Gateway for Android');
    }

    public function test_app_uses_tanzania_timezone_by_default(): void
    {
        $this->assertSame('Africa/Nairobi', config('app.timezone'));
    }

    public function test_admin_can_send_test_sms_with_gateway_credentials(): void
    {
        Http::fake([
            'api.sms-gate.app/*' => Http::response(['id' => 'sms-123'], 202),
        ]);

        config()->set('sms_gateway.enabled', true);
        config()->set('sms_gateway.username', 'gateway-user');
        config()->set('sms_gateway.password', 'gateway-pass');

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.sms-gateway.test'), [
                'phone' => '0673746031',
                'message' => 'Test SMS.',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('sms_logs', [
            'phone' => '+255673746031',
            'type' => 'test',
            'status' => 'sent',
            'provider_message_id' => 'sms-123',
        ]);

        Http::assertSent(fn ($request) => str_starts_with($request->url(), 'https://api.sms-gate.app/3rdparty/v1/messages')
            && str_contains($request['textMessage']['text'], 'CHILD AND YOUTH DEVELOPMENT CENTER (CYDC)')
            && str_contains($request['textMessage']['text'], 'Shalom!')
            && str_contains($request['textMessage']['text'], 'Test SMS.')
            && str_contains($request['textMessage']['text'], 'Best Regards,')
            && str_contains($request['textMessage']['text'], 'CYDC ACTIVITIES DATABASE')
            && str_contains($request['textMessage']['text'], 'support@cydcactivitiesdb.or.tz')
            && $request['phoneNumbers'] === ['+255673746031']
            && $request['ttl'] === 3600
            && $request['priority'] === 100);
    }

    public function test_tanzania_phone_numbers_are_normalized_for_sms_gateway(): void
    {
        $sender = app(SmsSender::class);

        $this->assertSame('+255614036031', $sender->normalizePhone('0614036031'));
        $this->assertSame('+255614036031', $sender->normalizePhone('+255614036031'));
        $this->assertSame('+255614036031', $sender->normalizePhone('255614036031'));
        $this->assertSame('+255614036031', $sender->normalizePhone('2550614036031'));
        $this->assertSame('+255614036031', $sender->normalizePhone('00255614036031'));
        $this->assertSame('+255614036031', $sender->normalizePhone('614036031'));
        $this->assertSame('+255714036031', $sender->normalizePhone('0714 036 031'));
    }

    public function test_scheduled_sms_reminders_are_personalized(): void
    {
        Http::fake([
            'api.sms-gate.app/*' => Http::response(['id' => 'sms-123'], 202),
        ]);

        config()->set('sms_gateway.enabled', true);
        config()->set('sms_gateway.username', 'gateway-user');
        config()->set('sms_gateway.password', 'gateway-pass');
        config()->set('sms_gateway.reminders.enabled', true);
        config()->set('sms_gateway.reminders.sleep_seconds', 0);
        config()->set('sms_gateway.reminders.messages.morning', 'Good morning {name}. This is a kind reminder to fill in your center data in the CYDC Activities Database system. Have a blessed morning.');

        User::factory()->create([
            'role' => 'user',
            'status' => 'approved',
            'center_id' => 'TZ0827',
            'phone' => '0673746031',
        ]);

        $this->artisan('sms:send-reminder morning')
            ->assertSuccessful();

        Http::assertSent(fn ($request) => str_contains($request['textMessage']['text'], 'Good morning TZ0827.')
            && str_contains($request['textMessage']['text'], 'kind reminder to fill in your center data'));
    }

    public function test_blocked_numbers_are_not_sent_sms(): void
    {
        Http::fake();

        config()->set('sms_gateway.enabled', true);
        config()->set('sms_gateway.username', 'gateway-user');
        config()->set('sms_gateway.password', 'gateway-pass');
        config()->set('sms_gateway.blocked_numbers', ['0747746838', '0687752210']);

        $sender = app(SmsSender::class);
        $log = $sender->sendToPhone('0747746838', 'Test SMS.', 'test');

        $this->assertSame('blocked', $log->status);
        $this->assertSame('+255747746838', $log->phone);
        Http::assertNothingSent();
    }

    public function test_sms_failure_is_logged(): void
    {
        Http::fake([
            'api.sms-gate.app/*' => Http::response(['message' => 'Unauthorized'], 401),
        ]);

        config()->set('sms_gateway.enabled', true);
        config()->set('sms_gateway.username', 'bad-user');
        config()->set('sms_gateway.password', 'bad-pass');

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.sms-gateway.test'), [
                'phone' => '0673746031',
                'message' => 'Shalom! Test SMS.',
            ])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertDatabaseHas('sms_logs', [
            'phone' => '+255673746031',
            'type' => 'test',
            'status' => 'failed',
        ]);

        $this->assertNotNull(SmsLog::first()?->error_message);
    }
}
