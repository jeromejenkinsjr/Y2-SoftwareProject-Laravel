@extends('layouts.app')

@section('content')


<div class="container my-5">
    <div>
        <h2 class="mb-4">
            Recently Updated Games <i class="bi bi-controller ms-2"></i>
        </h2>
    </div>
    <div class="row g-4">
        <!-- Left: Newest Game (full card) -->
        <div class="col-md-6">
            <div class="h-100 shadow-sm border-0 position-relative overflow-hidden game-card">
                <div class="position-relative overflow-hidden">
                    <img src="{{ asset($newestGame->thumbnail) }}" class="card-img-top object-fit-cover thumbnail-img"
                        style="height:350px; object-fit: cover;" alt="{{ $newestGame->name }}">

                    <!-- Overlay title with black faded shadow -->
                    <div class="position-absolute bottom-0 w-100 px-3 py-2"
                        style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 50%, transparent 100%);">
                        <h1 class="text-white m-0 fw-bold">{{ $newestGame->title }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Two Smaller Games Stacked -->
        <div class="col-md-6 d-flex flex-column justify-content-between">
            @foreach($otherGames as $game)
            <div class="card mb-4 shadow-sm flex-grow-1 game-card overflow-hidden">
                <img src="{{ asset($game->thumbnail) }}" class="card-img-top object-fit-cover thumbnail-img"
                    style="height: 250px; object-fit: cover;" alt="{{ $game->title }}">

                <div class="card-body">
                    <h6 class="card-title fw-semibold">{{ $game->title }}</h6>
                    <p class="card-text text-muted small">{{ $game->description }}</p>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>


@endsection