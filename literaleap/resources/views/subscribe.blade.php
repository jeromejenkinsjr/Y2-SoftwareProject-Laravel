@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Choose Your Subscription Plan</h2>

    @if (auth()->user()->premium)
    <p class="text-center">
        You are already subscribed
        @if (auth()->user()->role)
        as a {{ ucfirst(auth()->user()->role) }}.
        @endif
    </p>
    @else
    <div class="row justify-content-center">
        <!-- Teacher Premium Plan -->
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h4 class="card-title">Teacher Premium</h4>
                    <p class="card-text">Empower young minds with structured curriculum tools, analytics, and tailored
                        lesson plans.</p>
                    <p class="card-text">
                        Start with a <strong>14-day free trial</strong>. Cancel anytime before you're charged.
                    </p>

                    <h5 class="card-subtitle mb-3 text-muted">€10.99 / month</h5>

                    <form action="{{ route('subscribe.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="teacher">
                        <button type="submit" class="btn btn-primary btn-block w-100">Subscribe as Teacher</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Student Premium Plan -->
        <div class="col-md-5">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <h4 class="card-title">Student Premium</h4>
                    <p class="card-text">Unlock full access to interactive lessons, games, and offline materials to
                        boost your literacy journey.</p>
                    <p class="card-text">
                        Start with a <strong>14-day free trial</strong>. Cancel anytime before you're charged.
                    </p>

                    <h5 class="card-subtitle mb-3 text-muted">€4.99 / month</h5>

                    <form action="{{ route('subscribe.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" value="student">
                        <button type="submit" class="btn btn-success btn-block w-100">Subscribe as Student</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection