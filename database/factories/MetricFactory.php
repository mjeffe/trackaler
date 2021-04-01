<?php

namespace Database\Factories;

use App\Models\Metric;
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
            'value' => (string)$this->faker->randomFloat(1, 20, 1300),
            'measured_on' => date('Y:m:d H:i:s', time()),
        ];
    }
}
