<?php

namespace Database\Seeders\Dev;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;

class UsersSeeder extends Seeder {
    public function run() {
        // \App\Models\User::factory(10)->create();

        $table = 'users';

        DB::table($table)->truncate();
        DB::table($table)->insert([
            'id' => 1,  // this is used by other dev data csv files in database/data/dev
            'name' => 'Asdf Foobar',
            'email' => 'asdf@asdf.com',
            'password' => password_hash('Welcome', PASSWORD_DEFAULT),
        ]);
    }
}
