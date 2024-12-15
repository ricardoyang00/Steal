{{-- resources/views/pages/purchase-history.blade.php --}}
@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/purchaseHistory/sort_menu.js') }}" defer></script>
    <div class="purchase-history-container">
        @if (auth()->check())
            @if (auth()->user()->buyer)
                @php
                    $buyerId = auth()->user()->buyer->id;
                    $currentSortBy = request('sortBy', 'time');
                    $currentDirection = request('direction', 'asc');
                @endphp

                <h1>Purchase History</h1>

                <!-- Sort Dropdown -->
                <div class="sort-options">
                    <div class="purchase-history-dropdown">
                        <button id="purchase-history-sort-dropdownButton" class="purchase-history-sort-dropdownButton" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                                    Order Time (Asc)
                                @endif
                            </span>
                        </button>
                        <ul class="purchase-history-select-order-options" aria-labelledby="dropdownButton">
                            {{-- Order Time Asc --}}
                            <li>
                                <a class="dropdown-item @if ($currentSortBy === 'time' && $currentDirection === 'asc') active @endif" href="{{ route('purchaseHistory') }}?sortBy=time&direction=asc">
                                    Order Time (Asc)
                                </a>
                            </li>
                            {{-- Order Time Desc --}}
                            <li>
                                <a class="dropdown-item @if ($currentSortBy === 'time' && $currentDirection === 'desc') active @endif" href="{{ route('purchaseHistory') }}?sortBy=time&direction=desc">
                                    Order Time (Desc)
                                </a>
                            </li>
                            {{-- Total Price Asc --}}
                            <li>
                                <a class="dropdown-item @if ($currentSortBy === 'totalPrice' && $currentDirection === 'asc') active @endif" href="{{ route('purchaseHistory') }}?sortBy=totalPrice&direction=asc">
                                    Total Price (Asc)
                                </a>
                            </li>
                            {{-- Total Price Desc --}}
                            <li>
                                <a class="dropdown-item @if ($currentSortBy === 'totalPrice' && $currentDirection === 'desc') active @endif" href="{{ route('purchaseHistory') }}?sortBy=totalPrice&direction=desc">
                                    Total Price (Desc)
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Display Order History -->
                @forelse ($orderHistory as $history)
                    @php
                        // Determine Order Status
                        $status = ($history['prePurchases']->count() > 0) ? 'Item Pending' : 'Completed';
                        // Count Delivered and Pending Items
                        $deliveredCount = $history['deliveredPurchases']->count();
                        $pendingCount = $history['prePurchases']->count();
                    @endphp

                    <div class="purchase-history-order-card">
                        <div class="purchase-history-order-card-body">
                            <!-- First Line: Date, Total Price, Status -->
                            <div class="purchase-history-order-card-body-firstLine">
                                <div>
                                    <strong>Date:</strong> {{ $history['formattedTime'] }}
                                </div>
                                <div>
                                    <strong>Total Price:</strong> ${{ number_format($history['totalPrice'], 2) }}
                                </div>
                                <div>
                                    <strong>Status:</strong>
                                    @if ($status === 'Completed')
                                        <span class="badge bg-success">{{ $status }}</span>
                                    @else
                                        <span class="badge bg-warning text-dark">{{ $status }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Second Line: Delivered and Pending Items Count -->
                            <div class="purchase-history-order-card-body-secondLine">
                                <div>
                                    <strong>Delivered Items:</strong> {{ $deliveredCount }}
                                </div>
                                <div>
                                    <strong>Pending Items:</strong> {{ $pendingCount }}
                                </div>
                            </div>

                            <!-- View Details Button -->
                            <div class="purchase-history-orderDetails">
                                <a href="{{ route('seller.purchases.details', ['id' => $history['order']->id]) }}" class="btn btn-primary btn-sm">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-orders" role="alert">
                        No orders found.
                    </div>
                @endforelse

                <!-- Pagination -->
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

