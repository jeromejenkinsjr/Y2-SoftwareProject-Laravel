@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Search Results for "<strong>{{ $query }}</strong>"</h2>

    {{-- Games --}}
    @if($games->count())
    <h4 class="mt-4">Games</h4>
    <div class="row">
        @foreach($games as $game)
        <div class="col-md-6 mb-3">
            <div class="card h-100" style="cursor: pointer;"
                onclick="window.location='{{ route('games.show', $game->id) }}'">
                {{-- Thumbnail --}}
                <img src="{{ asset( $game->thumbnail) }}" class="card-img-top" alt="{{ $game->title }}"
                    style="object-fit: cover; height: 200px;">

                <div class="card-body">
                    <h5 class="card-title">{{ $game->title }}</h5>
                    <p class="card-text">{{ \Illuminate\Support\Str::limit($game->description, 100) }}</p>

                    {{-- Categories as Genres --}}
                    @if($game->categories->count())
                    <p class="card-text text-muted mb-1">Genres:</p>
                    <div>
                        @foreach($game->categories as $category)
                        <span class="badge bg-secondary">{{ $category->name }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $games->appends(['query' => $query])->links('pagination::bootstrap-5') }}
    @endif

    {{-- Forum Posts --}}
    @if($posts->count())
    <h4 class="mt-4">Forum Posts</h4>
    <div class="list-group">
        @foreach($posts as $post)
        <div class="list-group-item">
            <h5 class="mb-1">{{ $post->title }}</h5>
            <p class="mb-1">{{ \Illuminate\Support\Str::limit($post->body, 120) }}</p>
        </div>
        @endforeach
    </div>
    {{ $posts->appends(['query' => $query])->links('pagination::bootstrap-5') }}
    @endif

    {{-- Shop Items --}}
    @if($shopItems->count())
    <h4 class="mt-4">Shop Items</h4>
    <div class="row">
        @foreach($shopItems as $item)
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column justify-content-between">
                    <h5 class="card-title">{{ $item->name }}</h5>
                    <a href="{{ route('shop.item.show', $item->id) }}" class="btn btn-primary mt-2">View Item</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $shopItems->appends(['query' => $query])->links('pagination::bootstrap-5') }}
    @endif

    {{-- No results --}}
    @if(!$posts->count() && !$games->count() && !$shopItems->count())
    <div class="alert alert-warning mt-4" role="alert">
        No results found.
    </div>
    @endif
</div>
@endsection