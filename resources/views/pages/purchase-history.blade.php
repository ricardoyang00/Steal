@extends('layouts.app')

@section('content')
<script src="{{ asset('js/purchaseHistory/sort_menu.js') }}" defer></script>
<div class="container">
    @if (auth_user())
        @if (auth_user()->buyer)
            @php
                $buyerId = auth_user()->buyer->id; // Ensure you are accessing the buyer's ID
                $currentSortBy = request('sortBy', 'time'); // Default to 'time'
                $currentDirection = request('direction', 'asc'); // Default to 'asc'
            @endphp
            <h1>Purchase History</h1>
            
            <!-- Sort Dropdown -->
            <div class="mb-3">
                <div class="dropdown">
                    <button id="dropdownButton" onclick="toggleDropdown()" class="btn btn-primary btn-sm">
                        Sort By:
                        <span id="selectedSort">
                            @if ($currentSortBy === 'time' && $currentDirection === 'asc')
                                Order Time (Asc)
                            @elseif ($currentSortBy === 'time' && $currentDirection === 'desc')
                                Order Time (Desc)
                            @elseif ($currentSortBy === 'totalPrice' && $currentDirection === 'asc')
                                Total Price (Asc)
                            @elseif ($currentSortBy === 'totalPrice' && $currentDirection === 'desc')
                                Total Price (Desc)
                            @endif
                        </span>
                    </button>
                    <div id="dropdownMenu" class="dropdown-menu" style="display: none;">
                        <!-- Order Time (Asc) -->
                        <form method="GET" action="{{ route('purchaseHistory', ['id' => $buyerId]) }}">
                            <input type="hidden" name="sortBy" value="time">
                            <input type="hidden" name="direction" value="asc">
                            <button type="submit" class="dropdown-item @if ($currentSortBy === 'time' && $currentDirection === 'asc') active @endif">
                                Order Time (Asc)
                            </button>
                        </form>
                        <!-- Order Time (Desc) -->
                        <form method="GET" action="{{ route('purchaseHistory', ['id' => $buyerId]) }}">
                            <input type="hidden" name="sortBy" value="time">
                            <input type="hidden" name="direction" value="desc">
                            <button type="submit" class="dropdown-item @if ($currentSortBy === 'time' && $currentDirection === 'desc') active @endif">
                                Order Time (Desc)
                            </button>
                        </form>
                        <!-- Total Price (Asc) -->
                        <form method="GET" action="{{ route('purchaseHistory', ['id' => $buyerId]) }}">
                            <input type="hidden" name="sortBy" value="totalPrice">
                            <input type="hidden" name="direction" value="asc">
                            <button type="submit" class="dropdown-item @if ($currentSortBy === 'totalPrice' && $currentDirection === 'asc') active @endif">
                                Total Price (Asc)
                            </button>
                        </form>
                        <!-- Total Price (Desc) -->
                        <form method="GET" action="{{ route('purchaseHistory', ['id' => $buyerId]) }}">
                            <input type="hidden" name="sortBy" value="totalPrice">
                            <input type="hidden" name="direction" value="desc">
                            <button type="submit" class="dropdown-item @if ($currentSortBy === 'totalPrice' && $currentDirection === 'desc') active @endif">
                                Total Price (Desc)
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Display Order History -->
            @forelse ($orderHistory as $history)
                <div class="order">
                    <h3>Order</h3>
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
                                    <td>€{{ number_format($purchase['value'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-right"><strong>Total Price:</strong></td>
                                <td><strong>€{{ number_format($history['totalPrice'], 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right"><strong>S-Coins Used:</strong></td>
                                <td><strong>{{ $history['coinsUsed'] }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @empty
                <p>No orders found.</p>
            @endforelse

            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @else
            <p>You must be a buyer to view the purchase history.</p>
        @endif
    @else
        <a href="{{ route('login') }}"></a>
    @endif
</div>
@endsection
