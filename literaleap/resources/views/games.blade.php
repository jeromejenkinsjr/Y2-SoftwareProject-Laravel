@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        @foreach($games as $game)
        <div class="col-md-4 mb-4">
            <div class="card h-100" style="cursor: pointer;"
                onclick="window.location='{{ route('games.show', $game->id) }}'">
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
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection