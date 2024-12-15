@extends('layouts.app')

@section('content')

    <div class="order-details-container">
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
                                    <div class="game-card-body">
                                        <h5 class="game-card-title">{{ $delivered['game_name'] }}</h5>
                                        <p class="game-card-text">
                                            <img src="{{ asset($delivered['game_image']) }}" class="card-img-top" alt="{{ $delivered['game_name'] }}">
                                            <strong>Number of Purchases:</strong> {{ $delivered['purchase_count'] }}<br>
                                            <strong>Base Price:</strong> ${{ number_format($delivered['base_price'], 2) }}
                                        </p>
                                        @if(!empty($delivered['cdk_codes']))
                                            <p class="cdks-card-text">
                                                <strong>CDK Codes:</strong>
                                                <ul>
                                                    @foreach($delivered['cdk_codes'] as $cdk)
                                                        <li>{{ $cdk }}</li>
                                                    @endforeach
                                                </ul>
                                            </p>
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
                    <div class="row">
                        @foreach ($prePurchases as $prePurchase)
                            <div class="prePurchase-card">
                                <div class="game-card">
                                    <div class="game-card-body">
                                        <h5 class="game-card-title">{{ $prePurchase['game_name'] }}</h5>
                                        <p class="game-card-text">
                                            <img src="{{ asset($prePurchase['game_image']) }}" class="img-fluid" alt="{{ $prePurchase['game_name'] }}">
                                            <strong>Number of Pre-Purchases:</strong> {{ $prePurchase['purchase_count'] }}<br>
                                            <strong>Base Price:</strong> ${{ number_format($prePurchase['base_price'], 2) }}
                                        </p>
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
