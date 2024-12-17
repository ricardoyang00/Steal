@extends('layouts.app')

@section('title', 'S-Coins History')

@section('content')

<div class="scoins-history-container">
    <div class="scoins-header">
        <a href="{{ route('scoins.index') }}" class="scoins-back-link">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <h1 class="scoins-title">My S-Coins History</h1>
    </div>

    <div class="scoins-history">
        <table class="scoins-history-table">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Date</th>
                    <th>Subtotal (€)</th>
                    <th>Coins Used</th>
                    <th>Coins Gained</th>
                    <th>Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                        $coinsGained = ceil($order->getPayment->value * 5);
                    @endphp
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($order->time)->format('H:i:s') }}</td>
                        <td>{{ \Carbon\Carbon::parse($order->time)->format('Y-m-d') }}</td>
                        <td>{{ number_format($order->getPayment->value, 2) }}</td>
                        <td id="used-coins">- {{ $order->coins }}</td>
                        <td id="gained-coins">+ {{ $coinsGained }}</td>
                        <td id="coins-balance"><strong>{{ $calculatedBalances[$order->id] }}</strong></td>
                    </tr>
                @endforeach
                @if ($orders->currentPage() == $orders->lastPage())
                    <tr>
                        <td>--:--:--</td>
                        <td>Registration</td>
                        <td>--</td>
                        <td>--</td>
                        <td id="gained-coins">+ 500</td>
                        <td id="coins-balance"><strong>500</strong></td>
                    </tr>
                @endif
            </tbody>
        </table>
        <div class="pagination-links">
            {{ $orders->links() }}
        </div>
    </div>
</div>

@endsection
