<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Créer mon compte');
    }

    public function test_new_users_can_register_with_a_valid_username(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'username' => 'testuser',
        ]);
    }

    public function test_registration_rejects_a_duplicate_username(): void
    {
        User::factory()->create(['username' => 'takenuser']);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'takenuser',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_registration_rejects_an_invalid_username(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'Jean Dupont!',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    public function test_registration_rejects_a_too_short_username(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'username' => 'ab',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }
}
