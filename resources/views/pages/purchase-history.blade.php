{{-- resources/views/pages/purchase-history.blade.php --}}
@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/purchaseHistory/sort_menu.js') }}" defer></script>
    <script src="{{ asset('js/purchaseHistory/filter_menu.js') }}" defer></script>

    <div class="purchase-history-container">
        @if (auth()->check())
            @if (auth()->user()->buyer)
                @php
                    $buyerId = auth()->user()->buyer->id;
                    $currentSortBy = request('sortBy', 'time');
                    $currentDirection = request('direction', 'desc');
                    $currentFilter = request('filter', 'all');
                @endphp

                <h1>Purchase History</h1>

                <!-- Sort and Filter Controls -->
                <div class="controls d-flex justify-content-between align-items-center mb-4">
                    <!-- Sort Dropdown -->
                    <div class="sort-options">
                        <div class="purchase-history-dropdown">
                            <button id="purchase-history-sort-dropdownButton" class="purchase-history-dropdownButton" type="button" aria-haspopup="true" aria-expanded="false">
                                Sort By:
                                <span id="selected-sort-option">
                                    @if ($currentSortBy === 'time' && $currentDirection === 'asc')
                                        Order Time (Asc)
                                    @elseif ($currentSortBy === 'time' && $currentDirection === 'desc')
                                        Order Time (Desc)
                                    @elseif ($currentSortBy === 'totalPrice' && $currentDirection === 'asc')
                                        Total Price (Asc)
                                    @elseif ($currentSortBy === 'totalPrice' && $currentDirection === 'desc')
                                        Total Price (Desc)
                                    @else
                                        Order Time (Desc)
                                    @endif
                                </span>
                                <span class="arrow">&#9662;</span> <!-- Small Arrow -->
                            </button>
                            <ul class="purchase-history-select-order-options" id="purchase-history-select-order-options" aria-labelledby="purchase-history-sort-dropdownButton">
                                {{-- Order Time Asc --}}
                                <li>
                                    <a class="dropdown-item @if ($currentSortBy === 'time' && $currentDirection === 'asc') active @endif" href="{{ route('purchaseHistory', array_merge(request()->all(), ['sortBy' => 'time', 'direction' => 'asc'])) }}">
                                        Order Time (Asc)
                                    </a>
                                </li>
                                {{-- Order Time Desc --}}
                                <li>
                                    <a class="dropdown-item @if ($currentSortBy === 'time' && $currentDirection === 'desc') active @endif" href="{{ route('purchaseHistory', array_merge(request()->all(), ['sortBy' => 'time', 'direction' => 'desc'])) }}">
                                        Order Time (Desc)
                                    </a>
                                </li>
                                {{-- Total Price Asc --}}
                                <li>
                                    <a class="dropdown-item @if ($currentSortBy === 'totalPrice' && $currentDirection === 'asc') active @endif" href="{{ route('purchaseHistory', array_merge(request()->all(), ['sortBy' => 'totalPrice', 'direction' => 'asc'])) }}">
                                        Total Price (Asc)
                                    </a>
                                </li>
                                {{-- Total Price Desc --}}
                                <li>
                                    <a class="dropdown-item @if ($currentSortBy === 'totalPrice' && $currentDirection === 'desc') active @endif" href="{{ route('purchaseHistory', array_merge(request()->all(), ['sortBy' => 'totalPrice', 'direction' => 'desc'])) }}">
                                        Total Price (Desc)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Filter Dropdown -->
                    <div class="filter-options">
                        <form id="filter-form" method="GET" action="{{ route('purchaseHistory') }}">
                            <!-- Preserve existing query parameters except 'filter' -->
                            @foreach(request()->all() as $key => $value)
                                @if($key !== 'filter' && $key !== 'page')
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endif
                            @endforeach

                            <div class="purchase-history-filter-dropdown">
                                <button id="purchase-history-filter-dropdownButton" class="purchase-history-filter-dropdownButton" type="button" aria-haspopup="true" aria-expanded="false">
                                    Filter:
                                    <span id="selected-filter-option">
                                        @if ($currentFilter === 'all')
                                            All
                                        @elseif ($currentFilter === 'Completed')
                                            Completed
                                        @elseif ($currentFilter === 'ItemPending')
                                            Item Pending
                                        @else
                                            All
                                        @endif
                                    </span>
                                    <span class="arrow">&#9662;</span>
                                </button>
                                <ul class="purchase-history-select-filter-options" id="purchase-history-select-filter-options" aria-labelledby="purchase-history-filter-dropdownButton">
                                    <li>
                                        <a class="filter-item @if ($currentFilter === 'all') active @endif" href="{{ route('purchaseHistory', array_merge(request()->all(), ['filter' => 'all'])) }}">
                                            All
                                        </a>
                                    </li>
                                    <li>
                                        <a class="filter-item @if ($currentFilter === 'Completed') active @endif" href="{{ route('purchaseHistory', array_merge(request()->all(), ['filter' => 'Completed'])) }}">
                                            Completed
                                        </a>
                                    </li>
                                    <li>
                                        <a class="filter-item @if ($currentFilter === 'ItemPending') active @endif" href="{{ route('purchaseHistory', array_merge(request()->all(), ['filter' => 'ItemPending'])) }}">
                                            Item Pending
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Display Order History as Tables -->
                <div id="order-history-list">
                    @forelse ($orderHistory as $history)
                        <table class="purchase-history-order-card">
                            <!-- Header Section -->
                            <thead class="bg-light">
                                <tr>
                                    <th colspan="3" class="text-start">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Order Date:</strong> {{ $history['formattedTime'] }}
                                            </div>
                                            <div>
                                                <strong>Status:</strong>
                                                @if ($history['status'] === 'Completed')
                                                    <span class="badge bg-success">{{ $history['status'] }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ $history['status'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <!-- Details Section -->
                            <tbody>
                                <tr>
                                    <td colspan="3">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Game Name</th>
                                                    <th>Quantity</th>
                                                    <th>Unit Price</th>
                                                    <th>Delivery Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($history['games'] as $game)
                                                    <tr>
                                                        <td>{{ $game['game_name'] }}</td>
                                                        <td>{{ $game['quantity'] }}</td>
                                                        <td>${{ number_format($game['unit_price'], 2) }}</td>
                                                        <td>
                                                            @if ($game['delivery_status'] === 'Delivered')
                                                                <span class="badge bg-success">{{ $game['delivery_status'] }}</span>
                                                            @else
                                                                <span class="badge bg-warning text-dark">{{ $game['delivery_status'] }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>

                            <!-- Footer Section -->
                            <tfoot class="bg-light">
                                <tr>
                                    <td colspan="3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong>Payment Method:</strong> {{ $history['payment'] }}
                                            </div>
                                            <div>
                                                <strong>Payment Status:</strong>
                                                <span class="badge bg-success">Approved</span>
                                            </div>
                                            <div>
                                                <strong>Total Price:</strong> ${{ number_format($history['totalPrice'], 2) }}
                                            </div>
                                            <!-- Manage Orders Button -->
                                            <div class="manage-orders-button">
                                                <a href="{{ route('orderDetails', ['id' => $history['order']->id]) }}" class="btn btn-primary">Manage Orders</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @empty
                        <div class="no-orders alert alert-info" role="alert">
                            No orders found.
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center">
                    {{ $orders->links() }}
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


