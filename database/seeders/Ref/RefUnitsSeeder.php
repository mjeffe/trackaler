<?php

namespace Database\Seeders\Ref;

use App\Models\Ref_unit;
use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class RefUnitsSeeder extends BaseSeeder {
    public function run() {
        $table = 'ref_units';

        DB::table($table)->truncate();

        $rows = SimpleExcelReader::create(database_path("data/ref/{$table}.csv"))
            ->useDelimiter('|')
            ->getRows()
            ->toArray();

        Ref_unit::insert($rows);
    }
}
