@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2 class="mb-4">❌ Subscription Cancelled</h2>
    <p>Your subscription process was cancelled or interrupted.</p>
    <a href="{{ route('subscribe') }}" class="btn btn-secondary mt-3">Try Again</a>
</div>
@endsection