@extends('layouts.app')

@section('content')
    <!-- Include the JavaScript files for handling CDK view toggling and cancellation functionality -->
    <script src="{{ asset('js/purchaseHistory/cancel_pending_order_items.js') }}" defer></script>
    <script src="{{ asset('js/purchaseHistory/order_details.js') }}" defer></script>

    <div class="order-details-container container mt-5">
        @if (auth()->check())
            @if (auth()->user()->buyer)
                <h1>Order Details</h1>
                
                <!-- Purchased Items Section -->
                <div class="order-purchases-details">
                    <h2>Purchased Items</h2>
                    <div class="order-deliveredPurchases">
                    @foreach ($deliveredPurchases as $delivered)
                        <div class="deliveredPurchase-card">
                            <div class="game-card">
                                <div class="image-container">
                                    <img src="{{ asset($delivered['game_image']) }}" alt="{{ $delivered['game_name'] }}" class="game-image">
                                    <div class="x-quantity">
                                        <strong>x</strong> {{ $delivered['purchase_count'] }}
                                    </div>
                                </div>
                                
                                <div class="game-card-body">
                                    <h5 class="game-card-title">{{ $delivered['game_name'] }}</h5>
                                    <div class="price">$ {{ number_format($delivered['base_price'], 2) }}</div>
                                    
                                    @if(!empty($delivered['cdk_codes']))
                                        <button class="view-cdks-btn">View CDKs</button>
                                        <div class="cdk-codes">
                                            <strong>CDK Codes:</strong>
                                            <ul>
                                                @foreach($delivered['cdk_codes'] as $cdk)
                                                    <li>{{ $cdk }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @foreach ($prePurchases as $prePurchase)
                        <div class="prePurchase-card">
                            <div class="game-card">
                                <!-- New Wrapper Div for Image and X Quantity -->
                                <div class="image-container">
                                    <img src="{{ asset($prePurchase['game_image']) }}" alt="{{ $prePurchase['game_name'] }}" class="game-image">
                                    <div class="x-quantity">
                                        <strong>X</strong> {{ $prePurchase['purchase_count'] }}
                                    </div>
                                </div>
                                
                                <div class="game-card-body">
                                    <h5 class="game-card-title">{{ $prePurchase['game_name'] }}</h5>
                                    <div class="price">$ {{ number_format($prePurchase['base_price'], 2) }}</div>
                                    <button 
                                        type="button" 
                                        class="btn btn-danger mt-3 delete-prepurchase-items-button" 
                                        data-purchase-ids="{{ implode(',', $prePurchase['purchase_ids']) }}"
                                        data-game="{{ $prePurchase['game_name'] }}"
                                        data-count="{{ $prePurchase['purchase_count'] }}"
                                        data-game-image="{{ asset($prePurchase['game_image']) }}"
                                    >
                                        Cancel Item Orders
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    </div>
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

    <!-- Custom Delete PrePurchase Modal -->
    <div class="custom-modal" id="deletePrePurchaseModal" role="dialog" aria-modal="true" aria-labelledby="deletePrePurchaseModalLabel">
        <div class="custom-modal-content">
            <span class="custom-modal-close" id="customModalClose" aria-label="Close Modal">&times;</span>
            <h2 id="deletePrePurchaseModalLabel">Cancel PrePurchase Orders</h2>
            <form method="POST" action="{{ route('prePurchases.delete') }}" id="deletePrePurchaseForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="modal-grid">
                        <div class="modal-left">
                            <img src="" alt="" class="modal-game-image" id="modal-game-image">
                            <p id="modal-game-name"></p>
                        </div>
                        <div class="modal-middle">
                            <div class="modal-buttons">
                                <button type="button" class="btn btn-minus" id="decreaseOrder">-</button>
                                <input type="number" id="remove_order_count" name="remove_order_count" min="1" readonly>
                                <button type="button" class="btn btn-plus" id="increaseOrder">+</button>
                            </div>
                        </div>
                        <div class="modal-right">
                            <!-- Intentionally left blank; delete button will be absolutely positioned -->
                        </div>
                    </div>
                    <!-- Container for dynamic hidden inputs -->
                    <div id="pre_purchase_ids_container"></div>
                </div>
                <!-- Delete button positioned absolutely at the bottom right -->
                <button type="submit" class="btn btn-danger delete-button-abs" id="deleteButton">Delete</button>
            </form>
        </div>
    </div>
@endsection




