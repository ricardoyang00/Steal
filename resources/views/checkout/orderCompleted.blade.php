@extends('layouts.app')

@section('title', 'Order Receipt')

@section('content')

<div class="order-checkout-completed-container">
    <h1 class="text-success">Order Completed Successfully!</h1>
    <p class="lead">Thank you for your purchase! Here is your receipt:</p>

    <table class="receipt-main-table">
        <thead>
            <tr>
                <th colspan="2">Receipt Details</th>
            </tr>
        </thead>
        <tbody>
            <!-- Ordered Games Section -->
            @if (count($prePurchasedItems) > 0)
                <tr class="purchase-type-header">
                    <td colspan="2">Ordered Games</td>
                </tr>
                @foreach ($prePurchasedItems as $item)
                    <tr class="purchase-items">
                        <td>{{ $item['gameName'] ?? 'Unknown' }}</td>
                        <td>€{{ number_format($item['value'], 2) }}</td>
                    </tr>
                @endforeach
            @endif

            <!-- Delivered Games Section -->
            @if (count($purchasedItems) > 0)
                <tr class="purchase-type-header">
                    <td colspan="2">Delivered Games</td>
                </tr>
                @foreach ($purchasedItems as $item)
                    <tr class="purchase-items">
                        <td>{{ $item['gameName'] ?? 'Unknown' }}</td>
                        <td>{{ $item['cdkCode'] ?? 'Unknown' }}</td>
                        <td>€{{ number_format($item['value'], 2) }}</td>
                    </tr>
                @endforeach
            @endif

            <!-- Canceled Purchases Section -->
            @if (count($canceledItems) > 0)
                <tr class="purchase-type-header">
                    <td colspan="2">Canceled Purchases</td>
                </tr>
                @foreach ($canceledItems as $item)
                    <tr class="purchase-items">
                        <td>{{ $item['gameName'] ?? 'Unknown' }}</td>
                        <td>€{{ number_format($item['value'], 2) }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
        <tfoot>
            <tr class="receipt-footer">
                <td class="footer-left">Coins Used: {{ $coinsUsed }}</td>
                <td class="footer-right">Total Price: €{{ number_format($subtotal, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <!-- Action Buttons -->
    <div class="back-to-home-button">
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>
@endsection



