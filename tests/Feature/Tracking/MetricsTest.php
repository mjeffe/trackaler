<?php

namespace Tests\Feature\Tracking;

use App\Models\User;
use App\Models\Metrics;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MetricsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_add_metric_screen() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tracker');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_submit_a_metric() {
        $user = User::factory()->create();

        $data = [
            'metric' => 'weight',
            'units' => 'lbs',
            'value' => '150',
            'measured_on' => date('Y-m-d'),
        ];

        $response = $this->actingAs($user)->post('/metrics', $data);

        $response->assertStatus(200);
        unset($data['measured_on']); // dates don't compare well to datetimes
        $this->assertDatabaseHas('metrics', $data);
    }
}
