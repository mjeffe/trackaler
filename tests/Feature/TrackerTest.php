<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Metrics;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Tracker\CreateMetricRequest;

class TrackerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->data = [
            'metric' => 'weight',
            'units' => 'lbs',
            'value' => '150',
            'measured_on' => date('Y-m-d 00:00:00'), // dates are stored as datetime
        ];

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
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
    public function it_can_render_add_metric_screen() {
        $response = $this->get('/tracker');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_submit_a_metric() {
        $response = $this->post('/tracker', $this->data);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('metrics', $this->data);
    }

    /**
     * @test
     * @dataProvider requiredFieldsProvider
     */
    public function it_will_fail_with_errors_when_required_field_is_not_submitted($field) {
        unset($this->data[$field]);

        $response = $this->post('/tracker', $this->data);

        $response->assertSessionHasErrors($field);
        $this->assertDatabaseMissing('metrics', $this->data);
    }

    /** @test */
    public function it_will_redirect_on_validation_error() {
        unset($this->data['value']);

        $response = $this->post('/tracker', $this->data);

        $response->assertStatus(302);
    }
}
