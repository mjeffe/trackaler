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

class TrackerDeleteTest extends TestCase
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
    public function it_can_delete_an_existing_tracker() {
        $response = $this->delete($this->url);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('trackers', $this->tracker->getAttributes());
    }

    /** @test */
    public function it_returns_not_found_when_trying_to_delete_a_non_existant_tracker() {
        $response = $this->delete('/tracker/777');

        $response->assertStatus(404);
    }

    /** @test */
    public function it_will_cascade_delete_of_metrics_when_deleting_an_existing_tracker() {
        $response = $this->delete($this->url);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseMissing('trackers', $this->tracker->getAttributes());
        $this->assertDatabaseMissing('metrics', ['tracker_id' => $this->tracker->id]);
    }

    /*
     * permission tests
     */

    /** @test */
    public function it_will_not_allow_deleting_a_tracker_the_user_does_not_own() {
        $user2 = User::factory()->create();
        $this->actingAs($user2);

        // have user2 try to delete user's tracker
        $response = $this->delete($this->url);

        $response->assertStatus(404);
        // make sure user2's tracker is still there
        $this->assertDatabaseHas('trackers', $this->tracker->getAttributes());
    }

}
