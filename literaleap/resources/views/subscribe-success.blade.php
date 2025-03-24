@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4">🎉 Subscription Successful!</h2>
    <p>Thank you for subscribing to LiteraLeap Premium.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go to Dashboard</a>
</div>
@endsection