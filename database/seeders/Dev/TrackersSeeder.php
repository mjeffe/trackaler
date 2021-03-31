<?php

namespace Database\Seeders\Dev;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class TrackersSeeder extends Seeder {
    public function run() {
        $table = 'trackers';

        DB::table($table)->truncate();

        $rows = SimpleExcelReader::create(database_path("data/dev/{$table}.csv"))
            ->useDelimiter('|')
            ->getRows();

        $rows->each(function(array $rowProperties) use ($table) {
            DB::table($table)->insert($rowProperties);
        });
    }
}
