@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Purchase History</h1>
    @forelse ($orderHistory as $history)
        <div class="order">
            <h3>Order ID: {{ $history['order']->id }}</h3>
            <p>Payment Method: {{ $history['payment'] }}</p>
            <p>Order Time: {{ $history['formattedTime'] }}</p>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Game</th>
                        <th>CDK</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($history['purchases'] as $purchase)
                        <tr>
                            <td>{{ $purchase['game'] }}</td>
                            <td>{{ $purchase['cdk'] }}</td>
                            <td>${{ number_format($purchase['value'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p>No orders found.</p>
    @endforelse
</div>
@endsection

