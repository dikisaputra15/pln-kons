<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_the_root_to_the_login_page(): void
    {
        $this->get('/')->assertRedirectToRoute('login');
    }

    public function test_the_login_page_renders_the_stisla_form(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertViewIs('auth.login')
            ->assertSee('stisla/dist/assets/css/style.css')
            ->assertSee('name="_token"', false);
    }

    public function test_guests_must_sign_in_to_access_home(): void
    {
        $this->get(route('home'))->assertRedirectToRoute('login');
    }

    public function test_valid_credentials_sign_the_user_in_and_redirect_to_home(): void
    {
        $user = User::factory()->create();

        $response = $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_display_an_error_on_the_login_form(): void
    {
        $user = User::factory()->create();

        $response = $this->followingRedirects()->from(route('login'))->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ]);

        $response->assertOk()
            ->assertSee('id="email-error"', false)
            ->assertSee($user->email);

        $this->assertGuest();
    }

    public function test_signed_in_users_are_redirected_from_the_root_to_home(): void
    {
        $this->actingAs(User::factory()->make())->get('/')->assertRedirectToRoute('home');
    }

    public function test_signed_in_users_can_view_home(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)->get(route('home'))
            ->assertOk()
            ->assertSeeText($user->name);
    }
}
