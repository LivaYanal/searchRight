<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_and_register_pages_load(): void
    {
        $this->get('/login')->assertOk()->assertSee('Inloggen');
        $this->get('/register')->assertOk()->assertSee('Account aanmaken');
    }

    public function test_a_user_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Livanur',
            'email' => 'livanur@example.com',
            'password' => 'geheim-wachtwoord',
            'password_confirmation' => 'geheim-wachtwoord',
        ]);

        $response->assertRedirect(route('companies.index'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'livanur@example.com']);
    }

    public function test_a_user_can_log_in_with_the_right_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect(route('companies.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_user_cannot_log_in_with_a_wrong_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', ['email' => $user->email, 'password' => 'fout'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_a_user_can_log_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
