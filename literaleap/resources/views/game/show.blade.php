@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Game Detail Card -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 fw-bold text-primary">{{ $game->title }}</h2>
                    <p class="text-muted">{{ $game->description }}</p>
                    <div class="mb-3">
                        @foreach($game->categories as $category)
                        <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </div>

                    <!-- Game Container -->
                    <div id="game-container" class="mb-3 mx-auto"
                        style="border: 1px solid #ccc; padding: 1rem; width: 600px;">
                    </div>


                    <!-- Link to go back -->
                    <a href="{{ route('games.index') }}" class="btn btn-secondary">Back to Games List</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="my-4">
        <h4>Reviews</h4>

        @if($game->reviews->count())
        @foreach($game->reviews as $review)
        <div class="border p-3 mb-3">
            <div class="d-flex justify-content-between">
                <div>
                    <strong>{{ $review->user->name }}</strong>
                    <span class="ms-2">Rating: {{ $review->rating }}/5</span>
                </div>
                @if($review->user_id === auth()->id())
                <div>
                    <a href="{{ route('reviews.edit', [$game->id, $review->id]) }}"
                        class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('reviews.destroy', [$game->id, $review->id]) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="return confirm('Are you sure you want to delete this review?')">Delete</button>
                    </form>
                </div>
                @endif
            </div>
            <p class="mt-2">{{ $review->review }}</p>
        </div>
        @endforeach
        @else
        <p>No reviews yet.</p>
        @endif

        <!-- If the user hasn't reviewed the game, show the review submission form -->
        @if(!$game->reviews->where('user_id', auth()->id())->count())
        <form method="POST" action="{{ route('reviews.store', $game->id) }}">
            @csrf
            <div class="mb-3">
                <label for="rating" class="form-label">Your Rating (1-5)</label>
                <select name="rating" id="rating" class="form-select w-auto">
                    @for($i = 1; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>
            </div>
            <div class="mb-3">
                <label for="review" class="form-label">Your Review</label>
                <textarea name="review" id="review" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
        @endif
    </div>
</div>
@endsection
@section('scripts')
<!-- Load p5.js from a CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/addons/p5.sound.min.js"></script>
<script src="{{ asset($game->file) }}"></script>
@endsection