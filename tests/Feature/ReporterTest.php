<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Metric;
use App\Models\Tracker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReporterTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $t = Tracker::factory()
            ->for($this->user)
            ->has(Metric::Factory()->count(3))
            ->create();

        $this->tracker = Tracker::with('metrics')->find($t->id);

        $this->url = '/reporter/' . $this->tracker->id . '/graph';
    }

    /** @test */
    public function it_can_render_graph_for_an_existing_tracker() {
        $response = $this->get($this->url);

        $response->assertSessionHasNoErrors();
        $response->assertSee('seriesData');
        $response->assertSee('goalSeriesData');
        $response->assertSee('Highcharts.chart');
    }

    /*
     * permission tests
     */

    /** @test */
    public function it_will_not_render_graph_for_a_tracker_the_user_does_not_own() {
        $user2 = User::factory()->create();
        $this->actingAs($user2);

        // have user2 try to graph user's tracker
        $response = $this->get($this->url);

        $response->assertStatus(404);
    }

}
