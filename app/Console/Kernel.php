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
        /*
         * spatie/laravel-backup started throwing errors on my dreamhost
         * account (somewhere around Jan/Feb of 2023)
         *
         *   mysqldump: Couldn't execute 'FLUSH TABLES': Access denied; you
         *     need (at least one of) the RELOAD or FLUSH_TABLES privilege(s) for
         *     this operation (1227)
         *
         * Some googling suggested passing the --no-tablespaces flag to
         * mysqldump would work.  When running mysqldump manually, this did
         * work, but passing it to spatie in the mysql->dump->addExtraOption
         * part of config/databas.php did not work. Since this was primarily a
         * learning project, and mostly unused now, I'm simply turning backups
         * off.
         */
        /*
        $schedule->command('backup:run')
            ->daily()->at(env('BACKUP_TIME', '03:00'))  // default runtime to 3:00 AM
            ->timezone('America/Chicago')               // US Central time
            ->environments([env('BACKUP_ENVIRONMENTS', 'production')])
            ->emailOutputOnFailure(env('MAIL_TO_ADDRESS'))
            ->onFailure(function (Stringable $output) {
                Log::error('Error backing up db: ' . $output);
            });

        $schedule->command('backup:clean')
            ->daily()->at(env('BACKUP_CLEAN_TIME', '02:00'))  // default runtime to 2:00 AM
            ->timezone('America/Chicago')               // US Central time
            ->environments([env('BACKUP_ENVIRONMENTS', 'production')])
            ->emailOutputOnFailure(env('MAIL_TO_ADDRESS'))
            ->onFailure(function (Stringable $output) {
                Log::error('Error backing up db: ' . $output);
            });
         */
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
