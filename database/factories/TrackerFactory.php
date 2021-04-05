<?php

namespace Database\Factories;

use App\Models\Tracker;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackerFactory extends Factory
{
    protected $model = Tracker::class;

    public function definition() {
        return [
            'metric' => $this->faker->unique()->word,
            'units' => Str::random(3),
            'description' => $this->faker->sentence,
            'goal_value' => null,
            'goal_date' => null,
        ];
    }

    // state changes

    public function withGoal() {
        return $this->state(function (array $attributes) {
            return [
                'goal_value' => $this->faker->randomFloat(1, 20, 1300),
                'goal_date' => $this->faker->dateTimeBetween('+1 week', '+3 months')
            ];
        });
    }
}
