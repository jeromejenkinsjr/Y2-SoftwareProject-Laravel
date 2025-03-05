@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Dashboard') }}</h2>
                </div>
                <div class="card-body">
                    <p class="text-muted">{{ __("You're logged in!") }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
