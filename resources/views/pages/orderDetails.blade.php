@extends('layouts.app')

@section('content')

    <div class="order-details-container container mt-5">
        @if (auth()->check())
            @if (auth()->user()->buyer)

                <h1>Order Details</h1>

                <!-- Purchased Items Section -->
                <div class="order-purchases-details">
                    <h2>Purchased Items</h2>
                    <div class="order-deliveredPurchases">
                        @foreach ($deliveredPurchases as $delivered)
                            <div class="deliveredPurchase-card">
                                <div class="game-card">
                                    <img src="{{ asset($delivered['game_image']) }}" alt="{{ $delivered['game_name'] }}" class="game-image">
                                    <div class="game-card-body">
                                        <h5 class="game-card-title">{{ $delivered['game_name'] }}</h5>
                                        <p class="game-card-text">
                                            <strong>X</strong> {{ $delivered['purchase_count'] }}<br>
                                        </p>
                                        <div class="price">$ {{ number_format($delivered['base_price'], 2) }}</div>
                                        @if(!empty($delivered['cdk_codes']))
                                            <button class="view-cdks-btn">View CDKs</button>
                                            <div class="cdk-codes">
                                                <strong>CDK Codes:</strong>
                                                <ul>
                                                    @foreach($delivered['cdk_codes'] as $cdk)
                                                        <li>{{ $cdk }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Pending Items Section -->
                <div class="order-prePurchases">
                    <h2>Pending Items</h2>
                    <div class="order-prePurchases">
                        @foreach ($prePurchases as $prePurchase)
                            <div class="prePurchase-card">
                                <div class="game-card">
                                    <img src="{{ asset($prePurchase['game_image']) }}" alt="{{ $prePurchase['game_name'] }}" class="game-image">
                                    <div class="game-card-body">
                                        <h5 class="game-card-title">{{ $prePurchase['game_name'] }}</h5>
                                        <p class="game-card-text">
                                            <strong>X</strong> {{ $prePurchase['purchase_count'] }}<br>
                                        </p>
                                        <div class="price">$ {{ number_format($prePurchase['base_price'], 2) }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    You must be a buyer to view the purchase history.
                </div>
            @endif
        @else
            <div class="alert alert-danger" role="alert">
                You must be logged in to view your purchase history.
                <a href="{{ route('login') }}" class="btn btn-link">Login</a>
            </div>
        @endif
    </div>

@endsection

