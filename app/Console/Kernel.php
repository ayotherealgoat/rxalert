<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\SendMedicationReminders::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('reminders:send')
            ->everyMinute()
            ->withoutOverlapping()
            ->runInBackground()
            ->before(function () {
                Log::info('Starting medication reminder schedule');
            })
            ->after(function () {
                Log::info('Finished medication reminder schedule');
            });
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}