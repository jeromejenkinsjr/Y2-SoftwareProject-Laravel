<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_creator_sees_manage_button()
{
    $user = User::factory()->create(['role' => 'teacher']);
    $team = Team::factory()->create(['created_by' => $user->id]);

    $team->users()->attach($user->id, [
        'role' => 'admin',
        'status' => 'accepted',
    ]);    

    $response = $this->actingAs($user)->get(route('teams.index'));

    $response->assertStatus(200);
    $response->assertSee('Manage');
}


    public function test_non_creator_does_not_see_manage_button()
    {
        $creator = User::factory()->create(['role' => 'teacher']);
        $nonCreator = User::factory()->create(['role' => 'student']);
        $team = Team::factory()->create(['created_by' => $creator->id]);

        $team->users()->attach($nonCreator->id);

        $response = $this->actingAs($nonCreator)->get('/teams');

        $response->assertStatus(200);
        $response->assertDontSee('Manage');
    }
}