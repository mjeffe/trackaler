<?php

namespace Database\Seeders\Dev;

use App\Models\Metric;
use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class MetricsSeeder extends BaseSeeder {
    public function run() {
        $table = 'metrics';

        DB::table($table)->truncate();

        $rows = SimpleExcelReader::create(database_path("data/dev/{$table}.csv"))
            ->useDelimiter('|')
            ->getRows()
            ->toArray();

        Metric::insert($this->prepForDbLoad($rows));
    }
}
