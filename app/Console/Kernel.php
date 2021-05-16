<?php

namespace App\Console;

use Illuminate\Support\Stringable;
use Illuminate\Support\Facades\Log;
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        $schedule->command('backup:run')
            ->daily()->at(env('BACKUP_TIME', '03:00'))  // default runtime to 3:00 AM
            ->timezone('America/Chicago')               // US Central time
            ->environments([env('BACKUP_ENVIRONMENTS', 'production')])
            ->emailOutputOnFailure(env('MAIL_TO_ADDRESS'))
            ->onFailure(function (Stringable $output) {
                Log::error('Error backing up db: ' . $output);
             });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
