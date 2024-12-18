@extends('layouts.app')

@section('title', 'Order Receipt')

@section('content')

<div class="order-checkout-completed-container">
    <h1 class="text-success">Order Completed Successfully!</h1>
    <p class="lead">Thank you for your purchase! Here is your receipt:</p>

    <table class="receipt-main-table">
        <tbody>
            <!-- Ordered Games Subtable -->
            @if (count($prePurchasedItems) > 0)
                <tr>
                    <td>
                        <div class="subtable-container">
                            <table class="subtable ordered-games">
                                <thead>
                                    <tr>
                                        <th colspan="2">Ordered Games</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($prePurchasedItems as $item)
                                        <tr class="purchase-items">
                                            <td>{{ $item['gameName'] ?? 'Unknown' }}</td>
                                            <td>€{{ number_format($item['value'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endif

            <!-- Delivered Games Subtable -->
            @if (count($purchasedItems) > 0)
                <tr>
                    <td>
                        <div class="subtable-container">
                            <table class="subtable delivered-games">
                                <thead>
                                    <tr>
                                        <th colspan="3">Delivered Games</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchasedItems as $item)
                                        <tr class="purchase-items">
                                            <td>{{ $item['gameName'] ?? 'Unknown' }}</td>
                                            <td>{{ $item['cdkCode'] ?? 'Unknown' }}</td>
                                            <td>€{{ number_format($item['value'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endif

            <!-- Canceled Purchases Subtable -->
            @if (count($canceledItems) > 0)
                <tr>
                    <td>
                        <div class="subtable-container">
                            <table class="subtable canceled-purchases">
                                <thead>
                                    <tr>
                                        <th colspan="2">Canceled Purchases</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($canceledItems as $item)
                                        <tr class="purchase-items">
                                            <td>{{ $item['gameName'] ?? 'Unknown' }}</td>
                                            <td>€{{ number_format($item['value'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr class="receipt-footer">
                <td colspan="3">
                    <div class="footer-left">Coins Used: {{ $coinsUsed }}</div>
                    <div class="footer-right">Total Price: €{{ number_format($subtotal, 2) }}</div>
                </td>
            </tr>
        </tfoot>
    </table>

    <!-- Action Buttons -->
    <div class="back-to-home-button">
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>
@endsection
