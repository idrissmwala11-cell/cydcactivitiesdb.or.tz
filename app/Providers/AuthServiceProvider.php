<?php

namespace App\Providers;

use App\Models\SkillsAttendance;
use App\Models\TalentAttendance;
use App\Models\TalentsInformation;
use App\Policies\SkillsAttendancePolicy;
use App\Policies\TalentAttendancePolicy;
use App\Policies\TalentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        SkillsAttendance::class => SkillsAttendancePolicy::class,
        TalentAttendance::class => TalentAttendancePolicy::class,
        TalentsInformation::class => TalentPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
