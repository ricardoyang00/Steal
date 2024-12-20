@extends('layouts.app')

@section('title', 'S-Coins')

@section('content')

<div class="scoins-container">
    <div class="scoins-header">
        <h1 class="scoins-title">S-Coins</h1>
        <a href="{{ route('scoins.history') }}" class="scoins-history-link">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </a>
    </div>
    <p class="scoins-lead">Manage your S-Coins and learn how they work.</p>

    <div class="scoins-info">
        <div class="scoins-balance">
            You currently have <strong class="scoins-number">{{ auth_user()->buyer->coins }}</strong> S-Coins
        </div>

        <h2>How S-Coins Work</h2>
        <ul>
            <li><strong>1 S-Coin = € 0.01</strong></li>
            <li>For each euro spent, you receive <strong>5 S-Coins</strong>.</li>
            <li>Upon registering, you receive <strong>500 S-Coins</strong> as a welcome bonus.</li>
            <li>You can use S-Coins to get discounts when buying games.</li>
        </ul>

        <h2>Using S-Coins</h2>
        <p>When you purchase games, you can apply your S-Coins to get a discount on the total price. The more S-Coins you have, the bigger the discount you can get!</p>

        <br>
        <br>
        <h2><i class="fa-solid fa-triangle-exclamation"></i> Note:</h2>
        <p id="scoins-note"><strong>S-Coins CANNOT be refunded</strong></p>
    </div>

    <div class="scoins-back-button">
        <a href="{{ route('home') }}" class="scoins-button">Back to Home</a>
    </div>
</div>

@endsection