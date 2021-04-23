<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Metric;
use App\Models\Tracker;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Tracker\CreateMetricRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MetricCreateTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->tracker = Tracker::factory()->for($this->user)->create();

        $this->url = '/tracker/' . $this->tracker->id . '/metric';
    }

    public function requiredFieldsProvider() {
        $rules = (new CreateMetricRequest())->rules();

        $fields = [];
        foreach (array_keys($rules) as $field) {
            $validators = explode('|', $rules[$field]);
            if (in_array('required', $validators)) {
                $fields['unset ' . $field] = [$field];
            }
        }

        return $fields;
    }

    /** @test */
    public function it_can_render_the_create_metric_screen() {
        $response = $this->get($this->url . '/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_metric() {
        $this->data = Metric::factory()->for($this->tracker)->make()->getAttributes();

        $response = $this->post($this->url, $this->data);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('metrics', $this->data);
    }

    /**
     * @test
     * @dataProvider requiredFieldsProvider
     */
    public function it_will_fail_with_errors_when_required_field_is_not_submitted($field) {
        $this->data = Metric::factory()->for($this->tracker)->make()->getAttributes();
        unset($this->data[$field]);

        $response = $this->post($this->url, $this->data);

        $response->assertSessionHasErrors($field);
        $this->assertDatabaseMissing('metrics', $this->data);
    }

    /** @test */
    public function it_will_redirect_back_to_the_metric_form_on_validation_error() {
        $this->data = Metric::factory()->for($this->tracker)->make()->getAttributes();
        unset($this->data['measured_on']);

        $response = $this->from($this->url)->post($this->url, $this->data);

        $response->assertStatus(302);
        $response->assertRedirect($this->url);
    }

    /*
     * permission tests
     */

    /** @test */
    public function it_will_not_allow_creating_a_metric_for_a_tracker_the_user_does_not_own() {
        $countOfMetrics = Tracker::with('metrics')->find($this->tracker->id)->metrics->count();

        $user2 = User::factory()->create();
        $this->actingAs($user2);

        // have user2 try to create a metric for user's tracker
        $data = Metric::factory()->for($this->tracker)->make()->getAttributes();
        $response = $this->post($this->url, $data);

        $response->assertStatus(404);

        // make sure it wasn't acutally created
        $newCountOfMetrics = Tracker::with('metrics')->find($this->tracker->id)->metrics->count();
        $this->assertEquals($countOfMetrics, $newCountOfMetrics);
    }

}
