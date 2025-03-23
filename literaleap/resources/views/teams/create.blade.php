@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create a New Team</h1>

    {{-- Only Teachers/Admins are allowed to create teams --}}
    @if(!in_array(Auth::user()->role, ['teacher', 'admin']))
    <div class="alert alert-danger">
        You are not authorized to create a team.
    </div>
    @else
    <form method="POST" action="{{ route('teams.store') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Team Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter team name" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Team</button>
    </form>
    @endif

    <a href="{{ route('teams.index') }}" class="btn btn-link mt-3">Back to Teams</a>
</div>
@endsection