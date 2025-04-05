<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mockery;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoogleLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_existing_user_is_logged_in_through_google()
    {
        // Fake user in DB
        $existingUser = User::factory()->create([
            'email' => 'test@example.com',
            'google_id' => null,
        ]);

        // Mock Google user returned from Socialite
        $googleUser = Mockery::mock(ProviderUser::class);
        $googleUser->shouldReceive('getId')->andReturn('123456789');
        $googleUser->shouldReceive('getEmail')->andReturn('test@example.com');
        $googleUser->shouldReceive('getName')->andReturn('Test User');

        Socialite::shouldReceive('driver->stateless->user')
            ->once()
            ->andReturn($googleUser);

        $response = $this->get('/auth/google/callback');

        $this->assertAuthenticatedAs($existingUser->fresh());
        $response->assertRedirect('/dashboard');
        $this->assertEquals('123456789', $existingUser->fresh()->google_id);
    }

    public function test_new_user_is_created_and_logged_in_through_google()
    {
        $googleUser = Mockery::mock(ProviderUser::class);
        $googleUser->shouldReceive('getId')->andReturn('999999999');
        $googleUser->shouldReceive('getEmail')->andReturn('newuser@example.com');
        $googleUser->shouldReceive('getName')->andReturn('New Google User');

        Socialite::shouldReceive('driver->stateless->user')
            ->once()
            ->andReturn($googleUser);

        $response = $this->get('/auth/google/callback');

        $user = User::where('email', 'newuser@example.com')->first();

        $this->assertNotNull($user);
        $this->assertEquals('999999999', $user->google_id);
        $this->assertAuthenticatedAs($user);
        $response->assertRedirect('/dashboard');
    }
}