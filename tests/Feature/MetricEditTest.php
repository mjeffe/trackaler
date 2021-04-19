<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Metric;
use App\Models\Tracker;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Tracker\CreateMetricRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MetricEditTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->metric = Metric::factory()->for(Tracker::factory()->for($this->user))->create([
            'user_id' => $this->user->id
        ]);

        $this->url = '/tracker/' . $this->metric->tracker->id . '/metric/' . $this->metric->id;
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
    public function it_can_render_the_edit_metric_screen() {
        $response = $this->get($this->url . '/edit');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_pre_populates_the_edit_metric_screen_with_the_metric_data() {
        $response = $this->get($this->url . '/edit');

        $response->assertStatus(200);
        $response->assertSee($this->metric->value);
        $response->assertSee($this->metric->measured_on->toDateString());
    }

    /** @test */
    public function it_can_update_a_metric() {
        $this->data = $this->metric->getAttributes();
        $this->data['value'] = (string)(intval($this->data['value']) + 1);

        $response = $this->put($this->url, $this->data);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('metrics', $this->data);
    }

    /** @test */
    public function it_will_redirect_back_to_the_metric_form_on_validation_error() {
        $this->data = $this->metric->getAttributes();
        unset($this->data['measured_on']);

        $response = $this->from($this->url)->put($this->url, $this->data);

        $response->assertStatus(302);
        $response->assertRedirect($this->url);
    }

    /**
     * @test
     * @dataProvider requiredFieldsProvider
     */
    public function it_will_fail_with_errors_when_required_field_is_not_submitted($field) {
        $this->data = $this->metric->getAttributes();
        unset($this->data[$field]);

        $response = $this->put($this->url, $this->data);

        $response->assertSessionHasErrors($field);
        // make sure it didn't change
        $this->assertDatabaseHas('metrics', $this->metric->getAttributes());
    }

}
