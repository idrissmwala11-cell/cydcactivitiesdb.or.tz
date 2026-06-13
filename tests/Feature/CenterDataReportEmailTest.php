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
            'delivery_mode' => 'individual',
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

    public function test_admin_can_send_one_email_per_center_with_all_recipients_in_to(): void
    {
        Mail::fake();

        config()->set('center_data_reports.primary_admin_email', 'ekawira@tz.ci.org');
        config()->set('center_data_reports.secondary_admin_email', 'idrissmwala11@gmail.com');

        $admin = User::factory()->create(['role' => 'admin']);
        $centerOneUsers = User::factory()->count(5)->create(['center_id' => 'TZ001']);
        $centerTwoUser = User::factory()->create(['center_id' => 'TZ002']);

        $response = $this->actingAs($admin)->post(route('admin.center-data-reports.email'), [
            'caption' => 'Report ya pamoja ya kituo.',
            'delivery_mode' => 'grouped_center',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        Mail::assertSent(CenterDataReportMail::class, 2);
        Mail::assertSent(CenterDataReportMail::class, function (CenterDataReportMail $mail) use ($centerOneUsers) {
            $toAddresses = collect($mail->to)->pluck('address')->all();

            return $mail->centerId === 'TZ001'
                && $mail->centerUsersCount === 5
                && $mail->hasTo('ekawira@tz.ci.org')
                && $mail->hasTo('idrissmwala11@gmail.com')
                && $centerOneUsers->every(fn (User $user) => $mail->hasTo($user->email))
                && $toAddresses === [
                    'ekawira@tz.ci.org',
                    'idrissmwala11@gmail.com',
                    ...$centerOneUsers->pluck('email')->all(),
                ]
                && count($mail->cc) === 0;
        });
        Mail::assertSent(CenterDataReportMail::class, function (CenterDataReportMail $mail) use ($centerTwoUser) {
            return $mail->centerId === 'TZ002'
                && $mail->hasTo('ekawira@tz.ci.org')
                && $mail->hasTo('idrissmwala11@gmail.com')
                && $mail->hasTo($centerTwoUser->email)
                && count($mail->to) === 3
                && count($mail->cc) === 0;
        });
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
