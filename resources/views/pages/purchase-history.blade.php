@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Purchase History</h1>
    @forelse ($orderHistory as $history)
        <div class="order">
            <h3>Order ID: {{ $history['order']->id }}</h3>
            <p>Payment Method: {{ $history['payment']}}</p>
            <ul>
                @foreach ($history['purchases'] as $purchase)
                    <li>Purchase ID: {{ $purchase->id }} | Value: ${{ $purchase->value }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
</div>
@endsection
