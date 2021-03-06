<?php

namespace App\Console;

use App\Console\Commands\Bat\CreateRepeatingAppointmentsCommand;
use App\Console\Commands\Bat\CreateScheduledReportsCommand;
use App\Console\Commands\Bat\SendAppointmentRemindersCommand;
use App\Console\Commands\Bat\SendDnaFollowUpsCommand;
use App\Console\Commands\Bat\SendDnaRemindersCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(CreateRepeatingAppointmentsCommand::class)
            ->dailyAt('00:00');

        $schedule->command(CreateScheduledReportsCommand::class)
            ->dailyAt('09:00');

        $schedule->command(SendAppointmentRemindersCommand::class)
            ->everyMinute();

        $schedule->command(SendDnaFollowUpsCommand::class)
            ->everyMinute();

        $schedule->command(SendDnaRemindersCommand::class)
            ->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
