@extends('layouts.app')

@section('title', 'Order Receipt')

@section('content')
<div class="container mt-5">
    <h1 class="text-success">Order Completed Successfully!</h1>
    <p class="lead">Thank you for your purchase! Here is your receipt:</p>

    <div class="receipt mt-4">
        <h2 class="mb-3">Receipt Details</h2>

        <!-- Purchased Items Section -->
        <h3>Purchased Games</h3>
        @if (count($purchasedItems) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Game Name</th>
                        <th>CDK Code</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchasedItems as $item)
                        <tr>
                            <td>{{ $item['gameName'] ?? 'Unknown' }}</td>
                            <td>{{ $item['cdkCode'] ?? 'Unknown' }}</td>
                            <td>${{ number_format($item['value'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No games purchased in this transaction.</p>
        @endif

        <!-- Canceled Items Section -->
        @if (count($canceledItems) > 0)
            <h3 class="mt-5 text-danger">Canceled Games</h3>
            <p>The following games could not be purchased due to insufficient stock:</p>
            <ul>
                @foreach ($canceledItems as $item)
                    <li>Game Name: {{ $item['gameName'] }}</li>
                @endforeach
            </ul>
        @endif

        <!-- Total Price -->
        <div class="total mt-4">
            <h3>Total Price: ${{ number_format($total, 2) }}</h3>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-5">
        <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
    </div>
</div>
@endsection


