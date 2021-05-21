<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\Backup\Events\BackupZipWasCreated;
use ZipArchive;

/*
 * ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! !
 *
 * ! NOTE !  I would not recommend using this!
 *
 * This is really for my purposes on trackaler.com!
 *
 * This is an override of the encryption listener Spatie\Backup\Listeners\EncryptBackupArchive
 * in the spatie/backup-laravel package.
 *
 * The class is "overridden" by binding this class in App\Providers\AppServiceProvider
 *
 * ---------------
 *
 * This class differs from Spatie's class in that it:
 *  - ignores the config algorithm check
 *  - encrypts using a shell command for gpg
 *
 *  See notes in the encrypt() function!
 *
 * ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! ! !
 */
class EncryptBackupArchive {

    public function handle($event) {
        if (! $this->shouldEncrypt()) {
            return;
        }

        consoleOutput()->info("Encrypting zip archive...");

        $this->encrypt($event->pathToZip);

        consoleOutput()->info("Successfully encrypted zip archive");
    }

    protected function encrypt($fileName): void {
        $pw = static::getPassword();

        $cmd = "echo '$pw' | gpg --batch -c --passphrase-fd 0 '$fileName'";

        $this->run($cmd);

        // This is awkward... But it's the only way I could figure out to
        // unobtrusevly hook into Spatie's backup-laravel.
        //
        // We get a file named foo.zip, which we encrypt to foo.zip.gpg,
        // but the next step in Spatie's backup is to move this .zip file from
        // the temp dir to the destination disk and we have no way of
        // reporting back what the new file name is. So here we just rename the
        // .gpg to .zip, overwriting the original .zip
        $this->run("mv -f '${fileName}.gpg' '$fileName'");
    }

    public static function shouldEncrypt(): bool {
        $password = static::getPassword();

        if ($password === null) {
            return false;
        }

        return true;
    }

    protected static function getPassword(): ?string {
        return config('backup.backup.password');
    }

    private static function run($cmd) {
        $result = null;
        $output = [];
        exec($cmd, $output, $result);

        if ($result !== 0) {
            throw new \Exception("problem running exec() command");
        }

        // Return true on successfull command invocation
        return $result === 0;
    }
}
