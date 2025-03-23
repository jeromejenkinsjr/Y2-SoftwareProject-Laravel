<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Notifications\TeamInvitationNotification;

class TeamController extends Controller
{

    public function index()
    {
        $myTeams = Auth::user()->teams()->wherePivot('status', 'accepted')->get();
        $invitations = Auth::user()->teams()->wherePivot('status', 'pending')->get();
        return view('teams.index', compact('myTeams', 'invitations'));
    }
    // Only Teachers and Admins can create teams.
    public function create()
    {
        if (!in_array(auth()->user()->role, ['teacher', 'admin'])) {
            abort(403, 'Unauthorized');
        }
        return view('teams.create');
    }

    // Create a team with a unique team code and attach the creator as an admin.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        // Generate a unique team code (6-character alphanumeric)
        do {
            $teamCode = strtoupper(\Illuminate\Support\Str::random(6));
        } while (Team::where('team_code', $teamCode)->exists());

        // Create the team and set the creator.
        $team = Team::create([
            'name'       => $request->name,
            'team_code'  => $teamCode,
            'created_by' => auth()->id(),
        ]);

        // Attach the creator as an admin with accepted status.
        auth()->user()->teams()->attach($team->id, ['role' => 'admin', 'status' => 'accepted']);

        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    // Invite a user (Teacher or Student) to the team.
    public function invite(Request $request, Team $team)
    {
        // Only allow team admins/creator to send invites.
        if (!(in_array(auth()->user()->role, ['teacher', 'admin']) &&
        auth()->user()->teams()->wherePivot('status', 'accepted')->where('team_id', $team->id)->exists())) {
        abort(403, 'Unauthorized');
    }

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);
        // Prevent duplicate invitations or memberships.
        if ($team->users()->where('user_id', $request->user_id)->exists()) {
            return redirect()->back()->with('error', 'User is already in the team or has been invited.');
        }

        // Attach the invited user with pending status.
        $team->users()->attach($request->user_id, [
            'role'       => 'member',
            'status'     => 'pending',
            'invited_by' => auth()->id(),
        ]);
        
        dd($team->users);
        $invitee = User::find($request->user_id);
        $invitee->notify(new TeamInvitationNotification($team, auth()->user()));
        return redirect()->back()->with('success', 'Invitation sent.');
    }

    // Allow a user to join a team by entering its team code.
    public function joinByCode(Request $request)
    {
        $request->validate([
            'team_code' => 'required|string'
        ]);

        $team = Team::where('team_code', $request->team_code)->first();

        if (!$team) {
            return redirect()->back()->with('error', 'Invalid Team Code.');
        }

        // Check if the user is already a member.
        if ($team->users()->where('user_id', auth()->id())->exists()) {
            return redirect()->back()->with('error', 'You are already a member of this team.');
        }

        // Attach the user as an accepted member.
        auth()->user()->teams()->attach($team->id, ['role' => 'member', 'status' => 'accepted']);

        return redirect()->back()->with('success', 'You have successfully joined the team.');
    }

    // Handle responses to team invitations (accept or decline).
    public function respondInvitation(Request $request, $pivotId)
    {
        $request->validate([
            'response' => 'required|in:accepted,declined'
        ]);
        $response = $request->input('response');
        $userId = auth()->id();

        // Retrieve the pivot record from the team_user table.
        $pivot = DB::table('team_user')->where('id', $pivotId)->first();

        if (!$pivot) {
            return redirect()->back()->with('error', 'Invitation not found.');
        }

        if ($pivot->user_id != $userId) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        DB::table('team_user')->where('id', $pivotId)->update([
            'status'     => $response,
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Invitation ' . $response . '.');
    }

    // Display a management view for a team (only accessible to team admins/creator).
    public function manage(Team $team)
    {
        if (!auth()->user()->teams()->wherePivot('role', 'admin')->where('team_id', $team->id)->exists()) {
            abort(403, 'Unauthorized');
        }
        return view('teams.manage', compact('team'));
    }
}