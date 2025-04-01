@extends('layouts.app')

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


@section('content')
<div class="container">
    <div class="d-flex align-items-center mt-4 mb-4">
        @if ($team->image)
        <img src="{{ asset('images/' . $team->image) }}" alt="Team Image"
            style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; margin-right: 20px;">
        @else
        <div
            style="width: 80px; height: 80px; background-color: #e0e0e0; border-radius: 8px; margin-right: 20px; display: flex; align-items: center; justify-content: center;">
            <span class="text-muted">No Image</span>
        </div>
        @endif
        <div>
            <h1 class="mb-0">Manage Team: {{ $team->name }}</h1>
            <small class="text-muted">Team Code: {{ $team->team_code }}</small>
        </div>
    </div>

    {{-- List Team Members --}}
    <div class="mb-4">
        <h3>Team Members</h3>
        @if($team->users->count())
        <ul class="list-group">
            @foreach($team->users as $member)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    {{ $member->name }}
                    <span class="badge bg-secondary">{{ $member->pivot->role }}</span>
                </div>

                {{-- Show Remove button if user is not an admin --}}
                @if(Auth::user()->teams()->where('team_id', $team->id)->wherePivot('role', 'admin')->exists() &&
                $member->pivot->role !== 'admin')
                <form method="POST" action="{{ route('teams.removeMember', [$team->id, $member->id]) }}"
                    onsubmit="return confirm('Are you sure you want to remove this member?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                </form>
                @endif
            </li>
            @endforeach

        </ul>
        @else
        <p class="text-muted">No members yet.</p>
        @endif
    </div>

    {{-- Edit Team Info --}}
    <div class="mb-5">
        <h3>Edit Team Info</h3>
        <form method="POST" action="{{ route('teams.update', $team->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Team Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $team->name }}" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Team Image</label>
                <input type="file" class="form-control" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
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

    {{-- Delete Team --}}
    <div class="mt-5">
        <form method="POST" action="{{ route('teams.destroy', $team->id) }}"
            onsubmit="return confirm('Are you sure you want to delete this team? This action cannot be undone.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Team</button>
        </form>
    </div>


    <a href="{{ route('teams.index') }}" class="btn btn-link">Back to Teams</a>
</div>
@endsection