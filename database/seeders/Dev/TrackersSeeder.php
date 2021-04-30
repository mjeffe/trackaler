<?php

namespace Database\Seeders\Dev;

use App\Models\Tracker;
use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class TrackersSeeder extends BaseSeeder {
    public function run() {
        $table = 'trackers';

        DB::table($table)->truncate();

        $rows = SimpleExcelReader::create(database_path("data/dev/{$table}.csv"))
            ->useDelimiter('|')
            ->getRows()
            ->toArray();

        Tracker::insert($this->prepForDbLoad($rows));
    }
}
