<?php

namespace Tests\Feature;

use App\Mail\CenterDataReportMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CenterDataReportEmailTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_send_personalized_center_reports_to_non_admin_users(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
            'center_id' => 'ADMIN',
        ]);
        $firstUser = User::factory()->create(['center_id' => 'TZ001']);
        $secondUser = User::factory()->create(['center_id' => 'TZ002']);
        User::factory()->create(['center_id' => null]);

        $response = $this->actingAs($admin)->post(route('admin.center-data-reports.email'), [
            'caption' => 'Tafadhali pitia taarifa ya ujazaji wa data ya center yako.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(CenterDataReportMail::class, 2);
        Mail::assertSent(CenterDataReportMail::class, function (CenterDataReportMail $mail) use ($firstUser) {
            return $mail->hasTo($firstUser->email)
                && $mail->centerId === 'TZ001'
                && $mail->caption === 'Tafadhali pitia taarifa ya ujazaji wa data ya center yako.';
        });
        Mail::assertSent(CenterDataReportMail::class, function (CenterDataReportMail $mail) use ($secondUser) {
            return $mail->hasTo($secondUser->email) && $mail->centerId === 'TZ002';
        });
        Mail::assertNotSent(CenterDataReportMail::class, fn (CenterDataReportMail $mail) => $mail->hasTo($admin->email));
    }

    public function test_regular_user_cannot_send_center_reports(): void
    {
        Mail::fake();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('admin.center-data-reports.email'), ['caption' => 'Report'])
            ->assertForbidden();

        Mail::assertNothingSent();
    }

    public function test_caption_is_required(): void
    {
        Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->post(route('admin.center-data-reports.email'), ['caption' => ''])
            ->assertSessionHasErrors('caption');

        Mail::assertNothingSent();
    }
}
