@extends('layouts.app')

@section('content')
<div class="container">
    @if (auth_user())
        @if (auth_user()->buyer)
            @php
                $buyerId = auth_user()->id; // Ensure you are accessing the buyer's ID
            @endphp
            <h1>Purchase History</h1>
            
            <div class="mb-3">
                <strong>Sort By:</strong>
                    <a href="{{ route('purchaseHistory', ['id' => auth_user()->buyer->id, 'sortBy' => 'time', 'direction' => 'asc']) }}" 
                    class="btn btn-primary btn-sm">Order Time (Asc)</a>
                    <a href="{{ route('purchaseHistory', ['id' => auth_user()->buyer->id, 'sortBy' => 'time', 'direction' => 'desc']) }}" 
                    class="btn btn-primary btn-sm">Order Time (Desc)</a>
                    <a href="{{ route('purchaseHistory', ['id' => auth_user()->buyer->id, 'sortBy' => 'totalPrice', 'direction' => 'asc']) }}" 
                    class="btn btn-primary btn-sm">Total Price (Asc)</a>
                    <a href="{{ route('purchaseHistory', ['id' => auth_user()->buyer->id, 'sortBy' => 'totalPrice', 'direction' => 'desc']) }}" 
                    class="btn btn-primary btn-sm">Total Price (Desc)</a>
            </div>


            <!-- Display Order History -->
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
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Total Price:</strong></td>
                                <td><strong>${{ number_format($history['totalPrice'], 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @empty
                <p>No orders found.</p>
            @endforelse
        @else
            <p>You must be a buyer to view the purchase history.</p>
        @endif
    @else
        <p>You must be logged in to view this page. <a href="{{ route('login') }}">Login here</a>.</p>
    @endif
</div>
@endsection
