<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('sms:send-reminder morning')
    ->dailyAt('07:30')
    ->timezone('Africa/Nairobi')
    ->withoutOverlapping();

Schedule::command('sms:send-reminder afternoon')
    ->dailyAt('12:00')
    ->timezone('Africa/Nairobi')
    ->withoutOverlapping();

Schedule::command('sms:send-reminder evening')
    ->dailyAt('20:00')
    ->timezone('Africa/Nairobi')
    ->withoutOverlapping();
