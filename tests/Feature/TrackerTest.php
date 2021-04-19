<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tracker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Tracker\CreateTrackerRequest;

class TrackerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->data = Tracker::factory()->for($this->user)->make()->getAttributes();
    }

    public function requiredFieldsProvider() {
        $rules = (new CreateTrackerRequest())->rules();

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
    public function it_can_render_tracker_screen() {
        $response = $this->get('/tracker');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_render_the_create_tracker_screen() {
        $response = $this->get('/tracker/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_new_tracker() {
        $response = $this->post('/tracker', $this->data);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trackers', $this->data);
    }

    /** @test */
    public function it_can_create_a_new_tracker_with_goal() {
        $this->data = Tracker::factory()->for($this->user)->withGoal()->make()->getAttributes();

        $response = $this->post('/tracker', $this->data);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trackers', $this->data);
    }

    /**
     * @test
     * @dataProvider requiredFieldsProvider
     */
    public function it_will_fail_with_errors_when_required_field_is_not_submitted($field) {
        unset($this->data[$field]);

        $response = $this->post('/tracker', $this->data);

        $response->assertSessionHasErrors($field);
        $this->assertDatabaseMissing('trackers', $this->data);
    }

    /** @test */
    public function it_will_redirect_on_validation_error() {
        unset($this->data['metric']);

        $response = $this->post('/tracker', $this->data);

        $response->assertStatus(302);
    }

    /** @test */
    public function it_will_render_a_list_of_all_trackers() {
        $trackers = Tracker::factory()->for($this->user)->count(3)->create();

        $response = $this->get('/tracker');

        $response->assertStatus(200);
        foreach ($trackers as $tracker) {
            $response->assertSeeText($tracker->description);
        }
    }
}
