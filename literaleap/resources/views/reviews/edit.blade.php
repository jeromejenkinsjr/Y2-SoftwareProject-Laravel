@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Review for {{ $game->title }}</h1>

    <form method="POST" action="{{ route('reviews.update', [$game->id, $review->id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="rating" class="form-label">Your Rating (1-5)</label>
            <select name="rating" id="rating" class="form-select w-auto">
                @for($i = 1; $i <= 5; $i++) <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>
                    {{ $i }}</option>
                    @endfor
            </select>
        </div>
        <div class="mb-3">
            <label for="review" class="form-label">Your Review</label>
            <textarea name="review" id="review" class="form-control" rows="3" required>{{ $review->review }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Review</button>
        <a href="{{ route('games.show', $game->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection