@extends('layouts.app')

@section('title', 'S-Coins')

@section('content')

<div class="scoins-container">
    <h1 class="scoins-title">S-Coins</h1>
    <p class="scoins-lead">Manage your S-Coins and learn how they work.</p>

    <div class="scoins-info">
        <div class="scoins-balance">
            You currently have <strong class="scoins-number">{{ auth_user()->buyer->coins }}</strong> S-Coins
        </div>

        <h2>How S-Coins Work</h2>
        <ul>
            <li>1 S-Coin = € 0.01.</li>
            <li>For each euro spent, you receive <strong>5 S-Coins</strong>.</li>
            <li>Upon registering, you receive <strong>500</strong> S-Coins as a welcome bonus.</li>
            <li>You can use S-Coins to get discounts when buying games.</li>
        </ul>

        <h2>Using S-Coins</h2>
        <p>When you purchase games, you can apply your S-Coins to get a discount on the total price. The more S-Coins you have, the bigger the discount you can get!</p>
    </div>

    <div class="scoins-back-button">
        <a href="{{ route('home') }}" class="scoins-button">Back to Home</a>
    </div>
</div>

    <div class="scoins-history">
        <h2>S-Coins History</h2>
        <table class="scoins-history-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Coins Used</th>
                    <th>Coins Gained</th>
                    <th>Subtotal (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                        $coinsGained = ceil($order->getPayment->value * 5);
                    @endphp
                    <tr>
                        <td>{{ $order->time }}</td>
                        <td>{{ $order->coins }}</td>
                        <td>{{ $coinsGained }}</td>
                        <td>{{ number_format($order->getPayment->value, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection