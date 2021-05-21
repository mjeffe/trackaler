<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            \Spatie\Backup\Listeners\EncryptBackupArchive::class,
            \App\Listeners\EncryptBackupArchive::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
