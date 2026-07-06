<?php

namespace Tests\Feature;

use App\Models\SmsLog;
use App\Models\User;
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
                'message' => 'Shalom! Test SMS.',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertDatabaseHas('sms_logs', [
            'phone' => '+255673746031',
            'type' => 'test',
            'status' => 'sent',
            'provider_message_id' => 'sms-123',
        ]);

        Http::assertSent(fn ($request) => $request->url() === 'https://api.sms-gate.app/3rdparty/v1/messages'
            && $request['textMessage']['text'] === 'Shalom! Test SMS.'
            && $request['phoneNumbers'] === ['+255673746031']);
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
