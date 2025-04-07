@extends('layouts.app')

@section('content')
<div class="container text-center py-5">
    <h1 class="display-4 text-danger">404 - Page Not Found</h1>
    <p class="lead">Oops! The page you're looking for doesn't exist.</p>
    <p>You will be redirected to your dashboard in <span id="countdown">5</span> seconds.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">Click here if not redirected</a>
</div>

<script>
let seconds = 5;
const countdown = document.getElementById('countdown');
const interval = setInterval(() => {
    seconds--;
    countdown.textContent = seconds;
    if (seconds <= 0) {
        clearInterval(interval);
        window.location.href = "{{ route('dashboard') }}";
    }
}, 1000);
</script>
@endsection