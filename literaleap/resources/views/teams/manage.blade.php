@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Manage Team: {{ $team->name }}</h1>

    <div class="mb-4">
        <h5>Team Code: <span class="text-muted">{{ $team->team_code }}</span></h5>
    </div>

    {{-- List Team Members --}}
    <div class="mb-4">
        <h3>Team Members</h3>
        @if($team->users->count())
        <ul class="list-group">
            @foreach($team->users as $member)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $member->name }}
                <span class="badge bg-secondary">{{ $member->pivot->role }}</span>
            </li>
            @endforeach
        </ul>
        @else
        <p class="text-muted">No members yet.</p>
        @endif
    </div>

    {{-- Invite Members --}}
    <div class="mb-4">
        <h3>Invite Member</h3>
        <form method="POST" action="{{ route('teams.invite', $team->id) }}">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID to Invite</label>
                <input type="number" name="user_id" id="user_id" class="form-control" placeholder="Enter User ID"
                    required>
                {{-- In a real app, you might use an autocomplete or email-based invite --}}
            </div>
            <button type="submit" class="btn btn-primary">Send Invitation</button>
        </form>
    </div>

    <a href="{{ route('teams.index') }}" class="btn btn-link">Back to Teams</a>
</div>
@endsection