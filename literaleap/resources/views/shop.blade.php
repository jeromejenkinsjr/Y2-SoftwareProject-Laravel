@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Credits Card -->
    <div class="row justify-content-center mt-4 mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>My Credits</h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('images/credit.png') }}" alt="Credits" width="100">
                    <h4>{{ auth()->user()->credits }} Credits</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Icons Section -->
    <h2 class="text-center mt-4">Icons</h2>
    <div class="row">
        @foreach($shopItems->where('type', 'icon') as $shopItem)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header text-center">
                    <h4>{{ $shopItem->name }}</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset($shopItem->image) }}" alt="{{ $shopItem->name }}"
                        class="rounded-circle img-thumbnail shadow mb-3"
                        style="width: 100px; height: 100px; object-fit: cover;">
                    <h5>Price: {{ $shopItem->price }} Credit{{ $shopItem->price > 1 ? 's' : '' }}</h5>

                    @if(auth()->user()->shopItems->contains($shopItem->id))
                    <div class="alert alert-success mt-3">Already Purchased</div>
                    @else
                    <form method="POST" action="{{ route('shop.buyItem', $shopItem->id) }}"
                        id="buy-item-form-{{ $shopItem->id }}">
                        @csrf
                        <button type="button" class="btn btn-primary mt-3 buy-item-button"
                            data-item-id="{{ $shopItem->id }}" data-item-price="{{ $shopItem->price }}">
                            Buy for {{ $shopItem->price }} Credit{{ $shopItem->price > 1 ? 's' : '' }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Regular Shop Items Section -->
    <h2 class="text-center mt-4">Profile Pictures</h2>
    <div class="row">
        @foreach($shopItems->where('type', 'item') as $shopItem)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-header text-center">
                    <h4>{{ $shopItem->name }}</h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset($shopItem->image) }}" alt="{{ $shopItem->name }}"
                        class="img-thumbnail shadow mb-3" style="width: 100px; height: 100px; object-fit: cover;">
                    <p>{{ $shopItem->description }}</p>
                    <h5>Price: {{ $shopItem->price }} Credit{{ $shopItem->price > 1 ? 's' : '' }}</h5>

                    @if(auth()->user()->shopItems->contains($shopItem->id))
                    <div class="alert alert-success mt-3">Already Purchased</div>
                    @else
                    <form method="POST" action="{{ route('shop.buyItem', $shopItem->id) }}"
                        id="buy-item-form-{{ $shopItem->id }}">
                        @csrf
                        <button type="button" class="btn btn-primary mt-3 buy-item-button"
                            data-item-id="{{ $shopItem->id }}" data-item-price="{{ $shopItem->price }}">
                            Buy for {{ $shopItem->price }} Credit{{ $shopItem->price > 1 ? 's' : '' }}
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Buy Item Confirmation Script -->
<script>
document.querySelectorAll('.buy-item-button').forEach(function(button) {
    button.addEventListener('click', function(e) {
        var itemId = e.target.getAttribute('data-item-id');
        var itemPrice = e.target.getAttribute('data-item-price');
        if (confirm('Are you sure you want to buy this item for ' + itemPrice + ' Credit' + (itemPrice >
                1 ? 's' : '') + '?')) {
            document.getElementById('buy-item-form-' + itemId).submit();
        }
    });
});
</script>
@endsection