<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_change_password_link_screen_can_be_rendered() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/change-password');

        $response->assertStatus(200);
    }

    public function test_password_can_be_changed() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/change-password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
    }

    public function test_current_password_is_required() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/change-password', [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors();
    }

    public function test_current_password_must_match_current_password() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/change-password', [
            'current_password' => 'bad-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors();
    }

    public function test_new_password_and_confirmation_must_match() {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/change-password', [
            'current_password' => 'bad-password',
            'password' => 'new-password',
            'password_confirmation' => 'missmatched-password',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors();
    }
}
