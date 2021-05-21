<?php

namespace App\Providers;

use App\Listeners\EncryptBackupArchive as OverrideEncryptBackupArchive;
use Spatie\Backup\Listeners\EncryptBackupArchive;
use Spatie\Backup\Events\BackupZipWasCreated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        // override the spatie/laravel-backup package's encryption listener
        // ! NOTE !  I would not recommend using this! See notes in the listener
        $this->app->bind(EncryptBackupArchive::class, OverrideEncryptBackupArchive::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // override the spatie/laravel-backup package's event trigger
        // ! NOTE !  I would not recommend using this! See notes in the listener
        if (OverrideEncryptBackupArchive::shouldEncrypt()) {
            Event::listen(BackupZipWasCreated::class, OverrideEncryptBackupArchive::class);
        }
    }
}
