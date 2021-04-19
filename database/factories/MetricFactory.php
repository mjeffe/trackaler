<?php

namespace Database\Factories;

use App\Models\Metric;
use App\Models\Tracker;
use Illuminate\Database\Eloquent\Factories\Factory;

class MetricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Metric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        return [
            'tracker_id' => Tracker::factory(),
            'value' => (string)$this->faker->randomFloat(1, 20, 1300),
            // random date, with today as max
            'measured_on' => $this->faker->date('Y-m-d', date('Y-m-d')),
        ];
    }
}
