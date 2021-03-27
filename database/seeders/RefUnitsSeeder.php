<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class RefUnitsSeeder extends Seeder {
    public function run() {
        $table = 'ref_units';

        DB::table($table)->truncate();

        $rows = SimpleExcelReader::create(database_path("data/ref/{$table}.csv"))
            ->useDelimiter('|')
            ->getRows();

        $rows->each(function(array $rowProperties) use ($table) {
            DB::table($table)->insert($rowProperties);
        });
    }
}
