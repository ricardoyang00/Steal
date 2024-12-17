@extends('layouts.app')

@section('title', 'Purchase Details')

@section('content')
<div class="puchase-details-page">
    <h1>Purchase Details</h1>

    <div class="purchase-details">
        <p><strong>Game</strong> <a href="{{ route('game.details', ['id' => $game->id]) }}">{{ $game->name }}</a></p>
        <p><strong>CDK</strong> {{ $purchase->cdk_code }}</p>
        <p><strong>Buyer Name</strong> {{ $purchase->buyer_name }}</p>
        <p><strong>Buyer Email</strong> {{ $purchase->buyer_email }}</p>
        <p><strong>Value</strong> €{{ number_format($purchase->value, 2) }}</p>
        <p><strong>Purchase Date</strong> {{ \Carbon\Carbon::parse($purchase->time)->format('d/m/Y H:i:s') }}</p>
        <p>
            <strong>Payment Method</strong>
            <span class="payment-method">
                {{ $purchase->payment_method_name }}
                <img src="{{ asset($purchase->payment_method_image) }}" alt="{{ $purchase->payment_method_name }}">
            </span>
        </p>
        @if(is_admin())
            <p><strong>Seller Name</strong> {{ $seller->seller_name }}</p>
            <p><strong>Seller Email</strong> {{ $seller->seller_email }}</p>
        @endif
    </div>

    <a href="{{ url()->previous() }}" class="back-btn">Back</a>
</div>
@endsection