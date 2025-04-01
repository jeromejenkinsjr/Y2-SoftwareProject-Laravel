@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Teams</h1>

    {{-- Create Team (Only for Teachers and Admins) --}}
    @if(in_array(Auth::user()->role, ['teacher', 'admin']))
    <div class="mb-4">
        <a href="{{ route('teams.create') }}" class="btn btn-primary">Create New Team</a>
    </div>
    @endif

    {{-- My Teams Section --}}
    <div class="mb-4">
        <h3>My Teams</h3>
        @if($myTeams->count())
        <ul class="list-group">
            @foreach($myTeams as $team)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    {{-- Team Image --}}
                    @if($team->image)
                    <img src="{{ asset('images/' . $team->image) }}" alt="Team Image"
                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; margin-right: 15px;">
                    @else
                    <div
                        style="width: 50px; height: 50px; background-color: #e0e0e0; border-radius: 8px; margin-right: 15px; display: flex; align-items: center; justify-content: center;">
                        <span class="text-muted" style="font-size: 12px;">No Image</span>
                    </div>
                    @endif

                    {{-- Team Info --}}
                    <div>
                        <strong>{{ $team->name }}</strong><br>
                        <small class="text-muted">Code: {{ $team->team_code }}</small>
                    </div>
                </div>

                {{-- Manage Button --}}
                @if(Auth::id() == $team->created_by)
                <a href="{{ route('teams.manage', $team->id) }}" class="btn btn-sm btn-outline-secondary">Manage</a>
                @endif
            </li>

            @endforeach
        </ul>
        @else
        <p class="text-muted">You are not a member of any teams yet.</p>
        @endif
    </div>

    @if($invitations->count())
    @foreach($invitations as $invitation)
    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <div>
            You've been invited by <strong>
                @if($invitation->pivot->invited_by)
                @php
                $inviter = \App\Models\User::find($invitation->pivot->invited_by);
                @endphp
                {{ $inviter ? $inviter->name : 'N/A' }}
                @else
                N/A
                @endif
            </strong> to join <strong>{{ $invitation->name }}</strong>.
        </div>
        <div>
            <form method="POST" action="{{ route('teams.respondInvitation', $invitation->pivot->id) }}"
                class="d-inline">
                @csrf
                <input type="hidden" name="response" value="accepted">
                <button type="submit" class="btn btn-sm btn-success">Accept</button>
            </form>
            <form method="POST" action="{{ route('teams.respondInvitation', $invitation->pivot->id) }}"
                class="d-inline">
                @csrf
                <input type="hidden" name="response" value="declined">
                <button type="submit" class="btn btn-sm btn-danger">Decline</button>
            </form>
        </div>
    </div>
    @endforeach
    @else
    <p class="text-muted">No pending invitations.</p>
    @endif

    {{-- Join a Team by Code --}}
    <div class="mb-4">
        <h3>Join a Team</h3>
        <form method="POST" action="{{ route('teams.join') }}">
            @csrf
            <div class="input-group">
                <input type="text" name="team_code" class="form-control" placeholder="Enter Team Code" required>
                <button type="submit" class="btn btn-outline-primary">Join</button>
            </div>
        </form>
    </div>
</div>
@endsection