<?php

namespace App\Console\Commands;

use Exception;
use ZipArchive;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/*
 * I have found this type of command (quickly and easily create an env from a
 * production backup) to be extremely helpful for every aspect of development
 * and maintaining a production system.  Having said that, I threw this one
 * together rather quickly. It is not well structured, and certainly not very
 * portable code.  It is tightly coupled to both the current
 * spatie/laravel-backup package, and to my current production environment and
 * the way I encrypt backups.
 * Although, I would still have to deal with encryption, fetching, etc,
 * something like spatie/laravel-db-snapshots might help improve this flow.
 *
 * The hope is, I will fix this someday...
 */
class TrkRestore extends Command {
    protected $indent = '    ';
    protected $backupFile = null;

    // each step will set these to the current file being acted on
    protected $activeFile = null;
    protected $activeDisk = null;

    protected $signature = 'trk:restore
        {--l|list : Print list of available backups}
        {--L|latest : Restore from the the latest backup available}
        {--d|date= : The date (YYYYMMDD) of the backup file to restore from, or the string "latest"}
        {--g|gpg-phrase= : GPG passphrase to decrypt database backup}
        {--f|file= : DISABLED! Restore from the given backup file (MUST use a full path)}
    ';
    // The --file option doesn't work because of the goofy "we don't know if it's
    // encrypted or just zipped" issue, so we just remove the file before processing.

    protected $description = 'Drops the current database and restores from a backup';

    public function handle() {
        // I could not get the sftp filesystem to work with a 'path/to/ssh/privateKey'
        // but it will work with the privateKey as a string.
        $key = env('BACKUP_REMOTE_KEY');
        Config::set('filesystems.disks.backups-remote.privateKey', `cat $key`);

        if ($this->option('list')) {
            return $this->handleList();
        }

        try {
            $this->verifyValidOptions();

            $this->handleRestore();
        } catch (Exception $e) {
            $this->error('Restore failed: ' . $e->getMessage());
            return 1;
        }
    }

    protected function handleList() {
        $this->info('Available backups:');

        $files = Storage::disk('backups-remote')->files();
        foreach ($files as $file) {
            $this->comment($this->indent . $file);
        }
    }

    protected function handleRestore() {
        $this->comment('Starting backup restore...');

        $this->getBackup();
        $this->decrypt();
        $this->unzip();
        $this->restoreFromBackup();
    }

    protected function getBackup() {
        if ($this->option('file')) {
            $this->backupFile = $this->option('file');
            return;
        }

        if ($this->option('date')) {
            $dateStr = $this->option('date');
        }
        elseif ($this->option('latest')) {
            // FIXME: this is a cheesy quick and dirty hack...
            $dateStr = date("Y-m-d");
        }
        else {
            throw new Exception('Missing one of required prameters: --file, --date, or --latest');
        }

        $fileName = $this->getFileNameByDate($dateStr);
        $this->comment("  found a backup file named $fileName");

        $this->backupFile = $fileName;
        return $this->fetchFile();
    }

    protected function fetchFile() {
        $remoteFile = $this->backupFile;
        $this->info("Fetching remote file $remoteFile...");

        $localFile = $remoteFile;
        Storage::disk('backups')->delete($localFile);

        try {
            // note, fetching from remote and storing to local 'backups' disk
            Storage::disk('backups')->put(
                $localFile,
                //Storage::disk('db_backups')->get($repoFile)
                Storage::disk('backups-remote')->getDriver()->readStream($remoteFile)
            );
        } catch (Exception $e) {
            $this->error("Fetching backup failed: {$e->getMessage()}.");

            throw $e;
        }

        $this->setActiveFile('backups', $localFile);
    }

    protected function decrypt() {
        $file = $this->getActiveFilePath();
        $this->info('Decrypting backup...');
        $this->info($this->indent . "file: $file");

        $fileParts = pathinfo($file);

        $decryptedFile = basename($fileParts['basename']);
        if ($fileParts['extension'] === 'gpg') {
            $decryptedFile = basename($fileParts['basename'], '.' . $fileParts['extension']);
        }

        // php buffers shell_exec()'s output, so we cannot pass it to
        // Storage::putFile() as a stream. Instead, we get the file path that
        // would be created, and allow gpg to create it.
        $decryptedFullFilePath = Storage::disk('local')->path($decryptedFile);
        $this->info($this->indent . "decryptedFullFilePath: $decryptedFullFilePath");
        Storage::disk('local')->delete($decryptedFile);

        $pw = $this->getEncryptionPassword();
        $cmd = "gpg -d --batch --passphrase '$pw' --output {$decryptedFullFilePath} {$file}";
        $this->cmd($cmd);

        if (Storage::disk('local')->missing($decryptedFile) || Storage::disk('local')->size($decryptedFile) < 1) {
            throw new Exception(
                "\n" .
                "There was a problem decrypting the backup file.\n" .
                "You can try running the following from the command line which may\n" .
                "provide more information:\n" .
                "\n" .
                "  $decryptCmd\n" .
                "\n"
            );
        }

        $this->setActiveFile('local', $decryptedFile);
    }

    protected function unzip() {
        $file = $this->getActiveFilePath();
        $this->info('Unzipping backup...');
        $this->info($this->indent . "file: $file");

        //$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
        $path = $this->getActiveDiskRoot();

        $zip = new ZipArchive;
        $zip->open($file);
        $zip->extractTo($path);
        $zip->close();

        // hard code bad... works for now
        // current version of backups extract to this
        $sqlFile = 'db-dumps/mysql-trackalercom.sql';
        Storage::disk($this->activeDisk)->delete($sqlFile);

        shell_exec("gzip -d {$path}/{$sqlFile}.gz");

        $this->setActiveFile(null, $sqlFile);
    }

    protected function restoreFromBackup() {
        $file = $this->getActiveFilePath();
        $this->info('restoring from backup...');
        $this->info($this->indent . "file: $file");

        Log::notice(
            "\n" .
            "-------------------------------------------------------\n" .
            "--                                                   --\n" .
            "-- Database restore from backup file:                --\n" .
            "--   " . $this->backupFile . "\n" .
            "--                                                   --\n" .
            "-------------------------------------------------------\n"
        );

        DB::unprepared(Storage::disk($this->activeDisk)->get($this->activeFile));
    }

    /*
     * Backup file names contain a full timestamp, but our parameter is only
     * date portion. Since A) we don't know the exact time of the backup, we can't
     * call Storage::exists() and B) the Laravel Storage system has no way to list
     * files using wild cards, here we get a list of all files and loop till
     * we find the one we want.
     */
    protected function getFileNameByDate($dateStr) {
        $availableBackups = Storage::disk('backups-remote')->files();

        foreach ($availableBackups as $file) {
            if (preg_match("/-{$dateStr}-/", $file)) {
                return $file;  
            }
        }
        
        throw new Exception(
            "\n" .
            "Unable to locate a backup file for the date $dateStr\n" . 
            "Try running this command with --list\n" . 
            "\n"               
        );
    }
  

    // set the storage disk and relative path to the file
    protected function setActiveFile($disk = null, $file = null) {
        $this->activeDisk = $disk ?? $this->activeDisk;
        $this->activeFile = $file ?? $this->activeFile;
    }

    protected function getActiveFilePath() {
        return Storage::disk($this->activeDisk)->path($this->activeFile);
    }

    protected function getActiveDiskRoot() {
        return config('filesystems.disks.' . $this->activeDisk . '.root');
    }

    protected function getEncryptionPassword() {
        return config('backup.backup.password');
    }

    // run a shell command, checking for failure
    private function cmd($cmd) {
        $result = null;
        $output = [];
        exec($cmd, $output, $result);

        if ($result !== 0) {
            throw new Exception("problem running exec() command");
        }

        // Return true on successfull command invocation
        return $result === 0;
    }

    protected function verifyValidOptions() {
        if ($this->option('list')) {
            return;
        }
        if ($this->option('file')) {
            //return;
            throw new Exception('The --file option is currently disabled');
        }
        if ($this->option('date')) {
            return;
        }
        if ($this->option('latest')) {
            return;
        }

        throw new Exception('Invalid command. Must use one of --list, --latest, --file, or --date');
    }

}
