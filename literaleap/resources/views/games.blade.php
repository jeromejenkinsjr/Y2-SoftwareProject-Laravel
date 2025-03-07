@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('My p5.js Game') }}</h2>
                </div>
                <div class="card-body text-center">
                    <h5 class="text-muted">Welcome to My p5.js Game</h5>
                    <div id="game-container" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.6.0/p5.js"></script>
<script src="{{ asset('js/game.js') }}"></script>
@endsection