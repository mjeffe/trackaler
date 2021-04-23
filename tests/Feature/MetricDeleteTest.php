<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Metric;
use App\Models\Tracker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Tracker\CreateTrackerRequest;

class MetricDeleteTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $t = Tracker::factory()
            ->for($this->user)
            ->has(Metric::Factory()->count(3))
            ->create();

        $this->tracker = Tracker::with('metrics')->find($t->id);

        $this->url = '/tracker/' . $this->tracker->id;
    }

    /** @test */
    public function it_can_delete_an_existing_metric() {
        $metric = $this->tracker->metrics->first();
        $response = $this->delete($this->url . '/' . $metric->metric_id);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('metrics', $metric->getAttributes());
    }

    /** @test */
    public function it_returns_not_found_when_trying_to_delete_a_non_existant_metric() {
        $response = $this->delete($this->url . '/777');

        $response->assertStatus(404);
    }

}
