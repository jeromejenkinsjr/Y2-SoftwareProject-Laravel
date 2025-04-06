@extends('layouts.app')

@section('content')
@if(session('error'))
<div class="alert alert-danger">
    {!! session('error') !!}
</div>
@endif

<div class="container mt-4 mb-4">
    <div class="row g-3">
        <!-- Search Form -->
        <div class="col-md-6">
            <form method="GET" action="{{ route('games.index') }}">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control mb-2"
                    placeholder="Search games...">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </form>
        </div>

        <!-- Filter by Category Form -->
        <div class="col-md-6">
            <form method="GET" action="{{ route('games.index') }}">
                <select name="category" class="form-select mb-2" onchange="this.form.submit()">
                    <option value="">Filter by Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                <noscript><button type="submit" class="btn btn-secondary w-100">Filter</button></noscript>
            </form>
        </div>

        <!-- Sort By Form -->
        <div class="col-md-6">
            <form method="GET" action="{{ route('games.index') }}">
                <select name="sort_by" class="form-select mb-2" onchange="this.form.submit()">
                    <option value="">Sort By</option>
                    <option value="average" {{ request('sort_by') == 'average' ? 'selected' : '' }}>Average Rating
                    </option>
                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
                <noscript>
                    <button type="submit" class="btn btn-secondary w-100">Sort</button>
                </noscript>
            </form>
        </div>
    </div>
</div>

<div class="container py-5">
    <div class="row">
        @foreach($games as $game)
        <div class="col-md-4 mb-4">
            @if($game->title === 'Coin Clicker' && (!Auth::check() || !Auth::user()->premium))
            <!-- For premium game accessed by non‑premium users: trigger modal -->
            <div class="card h-100" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#premiumModal">
                @else
                <!-- Regular behavior: navigate to the game show page -->
                <div class="card h-100" style="cursor: pointer;"
                    onclick="window.location='{{ route('games.show', $game->id) }}'">
                    @endif
                    <img src="{{ asset($game->thumbnail) }}" class="card-img-top" alt="{{ $game->title }}"
                        style="object-fit: cover; height:200px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $game->title }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($game->description, 100) }}</p>
                        <div>
                            @foreach($game->categories as $category)
                            <span class="badge bg-secondary">{{ $category->name }}</span>
                            @endforeach
                        </div>
                        @if(isset($game->reviews_avg_rating))
                        <div>
                            @for($i = 1; $i <= 5; $i++) @if($game->reviews_avg_rating >= $i)
                                <i class="bi bi-star-fill text-warning"></i>
                                @else
                                <i class="bi bi-star text-warning"></i>
                                @endif
                                @endfor
                                <span>({{ number_format($game->reviews_avg_rating, 1) }})</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Premium Modal -->
    <div class="modal fade" id="premiumModal" tabindex="-1" aria-labelledby="premiumModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="premiumModalLabel">Premium Feature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    This game is available only to premium members. Please subscribe to access this game.
                </div>
                <div class="modal-footer">
                    <a href="{{ route('subscribe') }}" class="btn btn-primary">Subscribe Now</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endsection