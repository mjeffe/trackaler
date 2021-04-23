<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Tracker;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Tracker\CreateTrackerRequest;

class TrackerEditTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);

        $this->tracker = Tracker::factory()->for($this->user)->create();

        $this->url = '/tracker/' . $this->tracker->id;
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
    public function it_can_render_the_edit_tracker_screen() {
        $response = $this->get($this->url . '/edit');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_pre_populates_the_edit_tracker_screen_with_the_trackers_data() {
        $response = $this->get($this->url . '/edit');

        $response->assertStatus(200);
        $response->assertSee($this->tracker->metric);
        $response->assertSee($this->tracker->units);
        $response->assertSee($this->tracker->description);
    }

    /** @test */
    public function it_can_update_a_tracker() {
        $this->data = $this->tracker->getAttributes();
        $this->data['units'] = substr($this->faker->word, 0, 8);

        $response = $this->put($this->url, $this->data);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trackers', $this->data);
    }

    /** @test */
    public function it_can_add_a_goal_value_to_an_existing_tracker() {
        $this->data = $this->tracker->getAttributes();
        $this->data['goal_value'] = $this->faker->randomFloat(1, 20, 1300);

        $response = $this->put($this->url, $this->data);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trackers', $this->data);
    }

    /** @test */
    public function it_can_add_a_goal_value_and_date_to_an_existing_tracker() {
        $this->data = $this->tracker->getAttributes();
        $this->data['goal_value'] = $this->faker->randomFloat(1, 20, 1300);
        $this->data['goal_date'] = $this->faker->dateTimeBetween('+1 week', '+3 months');

        $response = $this->put($this->url, $this->data);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('trackers', $this->data);
    }
    /**
     * @test
     * @dataProvider requiredFieldsProvider
     */
    public function it_will_fail_with_errors_when_required_field_is_not_submitted($field) {
        $this->data = $this->tracker->getAttributes();
        unset($this->data[$field]);

        $response = $this->put($this->url, $this->data);

        $response->assertSessionHasErrors($field);
        // make sure it didn't change
        $this->assertDatabaseHas('trackers', $this->tracker->getAttributes());
    }

    /** @test */
    public function it_will_redirect_back_to_the_tracker_form_on_validation_error() {
        $this->data = $this->tracker->getAttributes();
        unset($this->data['units']); // unset a required field

        $response = $this->from($this->url)->put($this->url, $this->data);

        $response->assertStatus(302);
        $response->assertRedirect($this->url);
    }

    /*
     * permission tests
     */

    /** @test */
    public function it_will_not_allow_editing_a_tracker_the_user_does_not_own() {
        $user2 = User::factory()->create();
        $this->actingAs($user2);

        $data = $this->tracker->getAttributes();
        $data['units'] = substr($this->faker->word, 0, 8);

        // have user2 try to update user's tracker
        $response = $this->put($this->url, $data);

        $response->assertStatus(404);
        // make sure user's tracker is unaltered
        $this->assertDatabaseHas('trackers', $this->tracker->getAttributes());
    }
}
