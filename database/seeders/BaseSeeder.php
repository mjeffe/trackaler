<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder {

    /*
     * TODO: this is kind of ugly... and violates SRP
     *
     * We could do this directly in the seeder, but it seemed a bit better
     * to extract it.
     *
     * $rows = SimpleExcelReader::create(database_path("data/dev/{$table}.csv"))
     *     ->useDelimiter('|')
     *     ->getRows()
     *     ->map(function(array $row) use ($now) {
     *         array_walk($row, function(&$value) {
     *             $value = $this->emptyStringToNull($value);
     *         });
     *
     *         $row['created_at'] = $now;
     *         $row['updated_at'] = $now; 
     *
     *         return $row;
     *     })
     *     ->toArray();
     */
    protected function prepForDbLoad(&$rows) {
        $now = Carbon::now('utc')->toDateTimeString();

        foreach ($rows as &$row) {
            // there *must* be a better way to do this... the CSV loads empty
            // fields as empty strings, but mysql timestamp fields will only accept
            // valid dates or null. so here we convert empty strings to nulls
            array_walk($row, function(&$value) {
                $value = $this->emptyStringToNull($value);
            });

            // Laravel bulk loading does not add timestamps, so here we add them
            $row['created_at'] = $now;
            $row['updated_at'] = $now; 
        }

        return $rows;
    }

	protected function emptyStringToNull($string) {
		if (trim($string) === '') {
			$string = null;
        }

		return $string;
	}
}
