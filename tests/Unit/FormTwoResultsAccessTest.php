<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class FormTwoResultsAccessTest extends TestCase
{
    public function test_results_2026_has_only_requested_classes(): void
    {
        $this->assertSame(['Darasa la Nne', 'Darasa la Saba'], config('form_two_results.classes.primary'));
        $this->assertSame(['Form 2', 'Form 4'], config('form_two_results.classes.secondary'));
    }

    public function test_admin_and_the_four_configured_users_have_access(): void
    {
        $admin = new User(['email' => 'admin@example.com', 'role' => 'admin']);
        $allowed = new User(['email' => 'SNASHON.TZ0827@GMAIL.COM', 'role' => 'user']);

        $this->assertTrue($admin->canAccessFormTwoResults());
        $this->assertTrue($allowed->canAccessFormTwoResults());
    }

    public function test_only_admin_and_configured_publisher_can_publish_results(): void
    {
        $admin = new User(['email' => 'admin@example.com', 'role' => 'admin']);
        $publisher = new User(['email' => 'SNASHON.TZ0827@GMAIL.COM', 'role' => 'user']);
        $resultsEditor = new User(['email' => 'amasele.tz0844@gmail.com', 'role' => 'user']);

        $this->assertTrue($admin->canPublishFormTwoResults());
        $this->assertTrue($publisher->canPublishFormTwoResults());
        $this->assertFalse($resultsEditor->canPublishFormTwoResults());
        $this->assertTrue($resultsEditor->canAccessFormTwoResults());
    }

    public function test_other_users_do_not_have_access(): void
    {
        $user = new User(['email' => 'other@example.com', 'role' => 'user']);

        $this->assertFalse($user->canAccessFormTwoResults());
    }
}
