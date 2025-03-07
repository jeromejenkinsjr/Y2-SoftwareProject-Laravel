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
</div>
@endsection
@section('scripts')
<!-- Load p5.js from a CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.min.js"></script>
// <script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/addons/p5.sound.min.js"></script>
<script src="{{ asset($game->file) }}"></script>
@endsection