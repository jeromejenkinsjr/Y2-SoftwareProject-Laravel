@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Review for {{ $game->title }}</h1>

    <form method="POST" action="{{ route('reviews.update', [$game->id, $review->id]) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Your Rating</label>
            <div id="star-rating" style="cursor: pointer;">
                @for ($i = 1; $i <= 5; $i++) @if ($review->rating >= $i)
                    <i class="bi bi-star-fill text-warning" data-value="{{ $i }}"></i>
                    @else
                    <i class="bi bi-star text-warning" data-value="{{ $i }}"></i>
                    @endif
                    @endfor
            </div>
            <input type="hidden" name="rating" id="rating" value="{{ $review->rating }}">
        </div>
        <div class="mb-3">
            <label for="review" class="form-label">Your Review</label>
            <textarea name="review" id="review" class="form-control" rows="3" required>{{ $review->review }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update Review</button>
        <a href="{{ route('games.show', $game->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#star-rating i');
    const ratingInput = document.getElementById('rating');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            ratingInput.value = rating;
            stars.forEach(s => {
                if (parseInt(s.getAttribute('data-value')) <= rating) {
                    s.classList.remove('bi-star');
                    s.classList.add('bi-star-fill');
                } else {
                    s.classList.remove('bi-star-fill');
                    s.classList.add('bi-star');
                }
            });
        });
    });
});
</script>

@endsection