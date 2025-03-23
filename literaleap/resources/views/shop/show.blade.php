@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{ $item->name }}</h2>
            <p class="card-text">Item ID: {{ $item->id }}</p>
            {{-- Add more item details here --}}
        </div>
    </div>
</div>
@endsection