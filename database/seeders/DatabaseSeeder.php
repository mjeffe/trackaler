<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    public function run() {
        $this->call([
            Ref\RefUnitsSeeder::class,
            // load order is important for referential integrity
            Dev\UsersSeeder::class,
            Dev\TrackersSeeder::class,
            Dev\MetricsSeeder::class,
        ]);
    }
}
