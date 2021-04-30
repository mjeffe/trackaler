<?php

namespace Database\Seeders\Dev;

use App\Models\User;
use Database\Seeders\BaseSeeder;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class UsersSeeder extends BaseSeeder {
    public function run() {
        // \App\Models\User::factory(10)->create();

        $table = 'users';

        DB::table($table)->truncate();

        $rows = SimpleExcelReader::create(database_path("data/dev/{$table}.csv"))
            ->useDelimiter('|')
            ->getRows()
            ->toArray();

        user::insert($this->prepForDbLoad($rows));
    }
}
