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

    /*
     * permission tests
     */

    /** @test */
    public function it_will_not_allow_deleting_a_metric_the_user_does_not_own() {
        $user2 = User::factory()->create();
        $this->actingAs($user2);

        // have user2 try to delete user's tracker
        $response = $this->delete($this->url);

        $response->assertStatus(404);
        // make sure user's tracker is still there
        $this->assertDatabaseHas('trackers', $this->tracker->getAttributes());
    }

}
