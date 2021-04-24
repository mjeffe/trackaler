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
    public function it_will_render_a_graph_for_an_existing_tracker() {
        $response = $this->get($this->url);

        $response->assertSessionHasNoErrors();
        $response->assertSee('seriesRawData');
        $response->assertSee('goalSeriesRawData');
        $response->assertSee('seriesData');
        $response->assertSee('goalSeriesData');
        $response->assertSee('Highcharts.chart');
    }

    /** @test */
    public function it_will_supply_metrics_series_data_in_measured_on_date_order() {
        // fetch metrics in date order
        $orderedMetrics = Metric::where('tracker_id', $this->tracker->id)
            ->orderBy('measured_on')
            ->get();

        // build the json encoded metrics data
        $metricsJson = json_encode(
            $orderedMetrics->map(function ($item) {
                return [
                    'metric_id' => $item->id,
                    'tracker_id' => $item->tracker_id,
                    'x' => $item->measured_on->valueOf(),
                    'y' => $item->value,
                ];
            })
        );

        $response = $this->get($this->url);

        $response->assertSessionHasNoErrors();
        $response->assertSee($metricsJson, false);
    }

    /** @test */
    public function it_will_supply_goal_series_data_if_tracker_has_goal() {
        $t = Tracker::factory()
            ->for($this->user)
            ->withGoal()
            ->has(Metric::Factory()->count(3))
            ->create();
        $this->url = '/reporter/' . $t->id . '/graph';

        $response = $this->get($this->url);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
        $response->assertSee('goalSeriesRawData = [{');
        $response->assertDontSee('goalSeriesRawData = []');
    }

    /** @test */
    public function it_will_start_goal_series_on_first_metric_when_tracker_has_goal_target_date() {
        $t = Tracker::factory()
            ->for($this->user)
            ->withGoal()
            ->has(Metric::Factory()->count(3))
            ->create();
        $this->url = '/reporter/' . $t->id . '/graph';

        $firstMetric = Metric::where('tracker_id', $t->id)
            ->orderBy('measured_on')
            ->first();

        $goalStartJson = json_encode([
            'x' => $firstMetric->measured_on->valueOf(),
            'y' => $firstMetric->value,
        ]);
        $goalStr = 'goalSeriesRawData = [' . $goalStartJson . ',';

        $response = $this->get($this->url);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
        $response->assertSee($goalStr, false);
    }

    /** @test */
    public function it_will_start_goal_series_on_first_metric_date_and_goal_value_when_tracker_has_no_goal_target_date() {
        $t = Tracker::factory()
            ->for($this->user)
            ->withGoalValue()
            ->has(Metric::Factory()->count(3))
            ->create();
        $this->url = '/reporter/' . $t->id . '/graph';

        $metrics = Metric::where('tracker_id', $t->id)
            ->orderBy('measured_on')
            ->get();

        $goalStartJson = json_encode([
            'x' => $metrics->first()->measured_on->valueOf(),
            'y' => (string)$t->goal_value,
        ]);
        $goalStr = 'goalSeriesRawData = [' . $goalStartJson . ',';

        $response = $this->get($this->url);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
        $response->assertSee($goalStr, false);
    }

    /** @test */
    public function it_will_end_goal_series_on_goal_date_and_value_when_tracker_has_no_goal_target_date() {
        $t = Tracker::factory()
            ->for($this->user)
            ->withGoal()
            ->has(Metric::Factory()->count(3))
            ->create();
        $this->url = '/reporter/' . $t->id . '/graph';

        $goalEndJson = json_encode([
            'x' => $t->goal_date->valueOf(),
            'y' => (string)$t->goal_value,
        ]);
        $goalStrs[] = 'goalSeriesRawData = [';
        $goalStrs[] = $goalEndJson . ']';

        $response = $this->get($this->url);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
        $response->assertSeeInOrder($goalStrs, false);
    }

    /** @test */
    public function it_will_end_goal_series_on_last_metric_date_and_goal_value_when_tracker_has_no_goal_target_date() {
        $t = Tracker::factory()
            ->for($this->user)
            ->withGoalValue()
            ->has(Metric::Factory()->count(3))
            ->create();
        $this->url = '/reporter/' . $t->id . '/graph';

        $metrics = Metric::where('tracker_id', $t->id)
            ->orderBy('measured_on')
            ->get();

        $goalEndJson = json_encode([
            'x' => $metrics->last()->measured_on->valueOf(),
            'y' => (string)$t->goal_value,
        ]);
        $goalStrs[] = 'goalSeriesRawData = [';
        $goalStrs[] = $goalEndJson . ']';

        $response = $this->get($this->url);

        $response->assertOk();
        $response->assertSessionHasNoErrors();
        $response->assertSeeInOrder($goalStrs, false);
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
