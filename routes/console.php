<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

Schedule::command('app:update-user-level')->daily();
Schedule::command('app:update-user-membership-years-badge')->daily();

Schedule::command('app:update-sitemap')->daily();

Schedule::command('disposable:update')->weekly();
