<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_games_list()
    {
        $user = User::factory()->create();
        $game = Game::factory()->create(['title' => 'Math Adventure']);

        $response = $this->actingAs($user)->get('/games');

        $response->assertStatus(200);
        $response->assertSee('Math Adventure');
    }
}