@extends('layouts.app')

@section('content')
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
    </div>
</div>



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