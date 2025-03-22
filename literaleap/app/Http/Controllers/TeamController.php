<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;

class TeamController extends Controller
{
public function create()
{
if (!in_array(auth()->user()->role, ['teacher', 'admin'])) {
abort(403, 'Unauthorized');
}
return view('teams.create');
}

public function store(Request $request)
{
// Validate team name
$request->validate([
'name' => 'required|string|max:255'
]);

// Generate a unique team code
do {
$teamCode = strtoupper(\Illuminate\Support\Str::random(6));
} while (Team::where('team_code', $teamCode)->exists());

// Create the team and set current user as creator
$team = Team::create([
'name' => $request->name,
'team_code' => $teamCode,
'created_by' => auth()->id(),
]);

// Add creator as team admin (status accepted)
auth()->user()->teams()->attach($team->id, ['role' => 'admin', 'status' => 'accepted']);

return redirect()->route('teams.index')->with('success', 'Team created successfully.');
}

public function invite(Request $request, Team $team)
{
    // Only allow the team's admin/creator to invite.
    if (!auth()->user()->teams()->wherePivot('role', 'admin')->where('team_id', $team->id)->exists()) {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    // Prevent duplicate invitations or memberships.
    if ($team->users()->where('user_id', $request->user_id)->exists()) {
        return redirect()->back()->with('error', 'User is already in the team or invited.');
    }

    $team->users()->attach($request->user_id, [
        'role' => 'member',
        'status' => 'pending',
        'invited_by' => auth()->id(),
    ]);

    $invitee = \App\Models\User::find($request->user_id);
    $invitee->notify(new \App\Notifications\TeamInvitationNotification($team, auth()->user()));

    return redirect()->back()->with('success', 'Invitation sent.');
}

public function joinByCode(Request $request)
{
    $request->validate([
        'team_code' => 'required|string'
    ]);

    $team = Team::where('team_code', $request->team_code)->first();

    if (!$team) {
        return redirect()->back()->with('error', 'Invalid Team Code.');
    }

    // Check if user is already a member.
    if ($team->users()->where('user_id', auth()->id())->exists()) {
        return redirect()->back()->with('error', 'You are already a member of this team.');
    }

    // Add the user as an accepted member.
    auth()->user()->teams()->attach($team->id, ['role' => 'member', 'status' => 'accepted']);

    return redirect()->back()->with('success', 'You have successfully joined the team.');
}
}