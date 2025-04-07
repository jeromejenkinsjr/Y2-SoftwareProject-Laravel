@extends('layouts.app')

@section('content')

<div class="container my-5">
    <div>
        <h2 class="mb-4">
            Recently Updated Games <i class="bi bi-controller ms-2"></i>
        </h2>
    </div>

    <div class="row g-4">
        <!-- Left: Newest Game (Full Height Card) -->
        <div class="col-md-6">
            <a href="{{ route('games.show', $newestGame->id) }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm border-0 overflow-hidden h-100">
                    <div class="position-relative">
                        <img src="{{ asset($newestGame->thumbnail) }}" class="w-100"
                            style="height: 350px; object-fit: cover;" alt="{{ $newestGame->title }}">

                        <div class="position-absolute bottom-0 w-100 px-3 py-2"
                            style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 50%, transparent 100%);">
                            <h1 class="text-white m-0 fw-bold">{{ $newestGame->title }}</h1>
                        </div>
                    </div>

                    @if(!empty($newestGame->description))
                    <div class="p-3">
                        <p class="text-muted mb-0">{{ $newestGame->description }}</p>
                    </div>
                    @endif
                </div>
            </a>
        </div>

        <!-- Right: Two Stacked Smaller Games -->
        <div class="col-md-6 d-flex flex-column gap-4">
            @foreach($otherGames as $game)
            <a href="{{ route('games.show', $game->id) }}" class="text-decoration-none text-dark">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <img src="{{ asset($game->thumbnail) }}" class="w-100" style="height: 160px; object-fit: cover;"
                        alt="{{ $game->title }}">
                    <div class="p-3">
                        <h5 class="fw-bold mb-1">{{ $game->title }}</h5>
                        <p class="text-muted mb-0">{{ Str::limit($game->description, 100) }}</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Recently Added Shop Items -->
    <div class="mt-5">
        <h2 class="mb-4 text-left">
            Newest Shop Items <i class="bi bi-bag-fill ms-2"></i>
        </h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 justify-content-center">
            @php
            $recentShopItems = \App\Models\ShopItem::latest()->take(4)->get();
            @endphp

            @foreach($recentShopItems as $item)
            <div class="col">
                <div class="card shadow-sm border-0 h-100 text-center p-3">
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                            class="rounded-circle img-thumbnail shadow mb-3"
                            style="width: 100px; height: 100px; object-fit: cover;">
                    </div>

                    <h6 class="fw-semibold">{{ $item->name }}</h6>
                    <p class="text-muted small mb-3">{{ Str::limit($item->description, 80) }}</p>

                    <a href="{{ route('shop') }}" class="btn btn-outline-primary btn-sm mt-auto">
                        View in Shop
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-left mt-4">
            <a href="{{ route('shop') }}" class="btn btn-primary">
                Visit Full Shop
            </a>
        </div>
    </div>

    <!-- Recent Forum Posts Section -->
    <div class="mt-5">
        <h2 class="mb-4">
            Latest Forum Discussions <i class="bi bi-chat-dots ms-2"></i>
        </h2>

        @php
        $recentForums = \App\Models\Post::latest()->take(3)->get();
        @endphp

        <div class="row g-4">
            @foreach($recentForums as $forum)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-2">{{ $forum->title }}</h5>
                        <p class="text-muted small mb-0">
                            {{ Str::limit(strip_tags($forum->body), 100) }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            <a href="{{ url('/forum') }}" class="btn btn-primary">
                View All Forums
            </a>
        </div>
    </div>

</div>

@endsection