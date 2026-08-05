<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Tests\TestCase;

class GithubAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_github_redirect_route_is_accessible_to_guests(): void
    {
        Socialite::shouldReceive('driver')->with('github')->andReturn(
            Mockery::mock()->shouldReceive('redirect')
                ->andReturn(redirect('https://github.com/login/oauth/authorize'))
                ->getMock()
        );

        $response = $this->get('/auth/github');

        $response->assertStatus(302);
        $response->assertRedirect('https://github.com/login/oauth/authorize');
    }

    public function test_github_callback_creates_a_new_user(): void
    {
        Http::fake(['api.github.com/*' => Http::response([])]);
        $this->mockGithubUser('12345', 'dev@example.com', 'dev-nick', 'Dev Nick');

        $response = $this->get('/auth/github/callback');

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'username' => 'dev-nick',
            'email' => 'dev@example.com',
            'github_id' => '12345',
            'github_username' => 'dev-nick',
        ]);
    }

    public function test_github_callback_links_an_existing_user_by_email_without_duplicate(): void
    {
        Http::fake(['api.github.com/*' => Http::response([])]);
        $user = User::factory()->create(['email' => 'dev@example.com']);
        $this->mockGithubUser('12345', 'dev@example.com', 'dev-nick', 'Dev Nick');

        $response = $this->get('/auth/github/callback');

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
        $this->assertSame(1, User::where('email', 'dev@example.com')->count());
        $this->assertSame('12345', $user->fresh()->github_id);
        $this->assertSame(1, User::count());
    }

    public function test_github_callback_links_an_existing_user_by_github_id(): void
    {
        Http::fake(['api.github.com/*' => Http::response([])]);
        $user = User::factory()->create(['github_id' => '12345']);
        $this->mockGithubUser('12345', 'dev@example.com', 'dev-nick', 'Dev Nick');

        $response = $this->get('/auth/github/callback');

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticatedAs($user);
        $this->assertSame(1, User::count());
    }

    public function test_github_callback_handles_missing_email_and_nickname_safely(): void
    {
        Http::fake(['api.github.com/*' => Http::response([])]);
        $this->mockGithubUser('999', null, null, null);

        $response = $this->get('/auth/github/callback');

        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertAuthenticated();
        $user = User::where('github_id', '999')->first();
        $this->assertNotNull($user);
        $this->assertSame('999@users.noreply.github.com', $user->email);
        $this->assertNotNull($user->username);
        $this->assertMatchesRegularExpression('/^[a-z0-9_-]{3,30}$/', $user->username);
    }

    public function test_github_callback_creates_a_unique_username_for_new_users(): void
    {
        Http::fake(['api.github.com/*' => Http::response([])]);
        User::factory()->create(['username' => 'dev-nick']);
        $this->mockGithubUser('12345', 'other@example.com', 'dev-nick', 'Dev Nick');

        $response = $this->get('/auth/github/callback');

        $response->assertRedirect(route('dashboard', absolute: false));
        $user = User::where('github_id', '12345')->first();
        $this->assertNotNull($user);
        $this->assertNotSame('dev-nick', $user->username);
        $this->assertSame(2, User::count());
    }

    public function test_github_access_token_is_hidden_from_user_arrays(): void
    {
        Http::fake(['api.github.com/*' => Http::response([])]);
        $this->mockGithubUser('12345', 'dev@example.com', 'dev-nick', 'Dev Nick');

        $this->get('/auth/github/callback');

        $user = User::where('github_id', '12345')->firstOrFail();
        $this->assertSame('fake-access-token', $user->github_access_token);
        $this->assertArrayNotHasKey('github_access_token', $user->toArray());
    }

    private function mockGithubUser(?string $id, ?string $email, ?string $nickname, ?string $name): void
    {
        $githubUser = Mockery::mock('Laravel\Socialite\Two\User');
        $githubUser->shouldReceive('getId')->andReturn($id);
        $githubUser->shouldReceive('getEmail')->andReturn($email);
        $githubUser->shouldReceive('getNickname')->andReturn($nickname);
        $githubUser->shouldReceive('getName')->andReturn($name);
        $githubUser->token = 'fake-access-token';

        Socialite::shouldReceive('driver')->with('github')->andReturn(
            Mockery::mock()->shouldReceive('user')->andReturn($githubUser)->getMock()
        );
    }
}
