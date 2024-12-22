@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<script src="{{ asset('js/notifications/notifications.js') }}" defer></script>
<script src="{{ asset('js/notifications/notifications-buttons.js') }}" defer></script>
<div id="notifications-tab" class="notifications-container">
    <h1>Notifications</h1>

    @if(auth_user()->buyer)
        @if($notifications->isEmpty())
            <div class="no-notifications">
                You have no notifications at the moment.
            </div>
        @else
            <div class="notifications">
                @foreach ($notifications as $notification)
                    <div class="notification" data-id="{{ $notification['id'] }}" data-type="{{ $notification['type'] }}">
                        <div class="notification-card">
                            <div class="notification-header">
                                @if(in_array($notification['type'], ['Order', 'ShoppingCart', 'Wishlist']))
                                    <h5 class="notification-title">
                                        @if($notification['type'] === 'OrderCompleted' || $notification['type'] === 'Status Changed')
                                            <a href="{{ route('purchaseHistory') }}" class="notification-title-link">
                                                {{ $notification['title'] }}
                                            </a>
                                        @elseif($notification['type'] === 'ShoppingCart')
                                            <a href="{{ route('shopping_cart') }}" class="notification-title-link">
                                                {{ $notification['title'] }}
                                            </a>
                                        @elseif($notification['type'] === 'Wishlist')
                                            <a href="{{ route('wishlist') }}" class="notification-title-link">
                                                {{ $notification['title'] }}
                                            </a>
                                        @endif
                                    </h5>
                                @else
                                    <h5 class="notification-title">{{ $notification['title'] }}</h5>
                                @endif
                                <button class="delete-notification-button" data-id="{{ $notification['id'] }}" aria-label="Delete notification">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="notification-body">
                                <p class="notification-text">{{ $notification['description'] }}</p>
                                <small class="notification-time">
                                    {{ (new \DateTime($notification['time']))->format('F d Y, H:i') }}
                                </small>
                                @if(!$notification['is_read'])
                                    <span class="unread-notification-indicator"></span>
                                @endif
                                @if(in_array($notification['type'], ['Wishlist', 'ShoppingCart']))
                                    @if(($notification['parsedDetails']['specific_type'] === 'Price'))
                                        <button class="view-notification-details" type="button" data-toggle="collapse" data-target="#details-{{ $notification['id'] }}" aria-expanded="false" aria-controls="details-{{ $notification['id'] }}">
                                        {{ in_array($notification['type'], ['Wishlist', 'ShoppingCart']) ? 'View Details' : ($notification['type'] === 'Order' ? 'View Order Details' : 'View Details') }}
                                        </button>
                                    @endif
                                @else
                                    <button class="view-notification-details" type="button" data-toggle="collapse" data-target="#details-{{ $notification['id'] }}" aria-expanded="false" aria-controls="details-{{ $notification['id'] }}">
                                    {{ in_array($notification['type'], ['Wishlist', 'ShoppingCart']) ? 'View Details' : ($notification['type'] === 'Order' ? 'View Order Details' : 'View Details') }}
                                    </button>  
                                @endif             
                            </div>
                            <div class="notifications-collapse collapse" id="details-{{ $notification['id'] }}">
                                <div class="notification-details">
                                    @if($notification['type'] === 'Order Completed' || $notification['type'] === 'Status Change')
                                        <p><strong>Placed at:</strong> {{ $notification['orderDetails']['date'] }}</p>
                                        @php
                                            $purchasedGames = collect($notification['orderDetails']['purchases'])->filter(fn($purchase) => $purchase['type'] === 'Delivered');
                                            $prePurchasedGames = collect($notification['orderDetails']['purchases'])->filter(fn($purchase) => $purchase['type'] === 'Ordered');
                                        @endphp
                                        @if($prePurchasedGames->isNotEmpty())
                                        <h6>Ordered Games:</h6>
                                            <ul>
                                                @foreach($notification['orderDetails']['purchases'] as $purchase)
                                                    @if($purchase['type'] === 'Ordered')
                                                        <li>@if(isset($purchase['gameId']))
                                                                <a href="{{ route('game.details', ['id' => $purchase['gameId']]) }}">
                                                                    {{ $purchase['gameName'] }}
                                                                </a>
                                                            @else
                                                                {{ $purchase['gameName'] }}
                                                            @endif
                                                             - €{{ number_format($purchase['value'], 2) }}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if($purchasedGames->isNotEmpty())
                                            <h6>Delivered Games:</h6>
                                            <ul>
                                                @foreach($notification['orderDetails']['purchases'] as $purchase)
                                                    @if($purchase['type'] === 'Delivered')
                                                        <li>@if(isset($purchase['gameId']))
                                                                <a href="{{ route('game.details', ['id' => $purchase['gameId']]) }}">
                                                                    {{ $purchase['gameName'] }}
                                                                </a>
                                                            @else
                                                                {{ $purchase['gameName'] }}
                                                            @endif
                                                             - €{{ number_format($purchase['value'], 2) }}
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                        @php
                                            $canceledGames = collect($notification['orderDetails']['purchases'])->filter(fn($purchase) => $purchase['type'] === 'Canceled');
                                        @endphp
                                        @if($canceledGames->isNotEmpty())
                                            <h6>Canceled Purchases:</h6>
                                            <ul>
                                                @foreach($notification['orderDetails']['purchases'] as $purchase)
                                                    @if($purchase['type'] === 'Canceled')
                                                        <li>
                                                            @if(isset($purchase['gameId']))
                                                                <a href="{{ route('game.details', ['id' => $purchase['gameId']]) }}">
                                                                    {{ $purchase['gameName'] }}
                                                                </a>
                                                            @else
                                                                {{ $purchase['gameName'] }}
                                                            @endif
                                                             - €{{ number_format($purchase['value'], 2) }}

                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
                                        <p><strong>Coins Used: </strong>{{ $notification['orderDetails']['coinsUsed'] ?? 0 }} S-Coins</p>
                                        <p><strong>Total Price: </strong>€{{ $notification['orderDetails']['totalPrice'] ?? 0.0 }}</p>
                                    @elseif(in_array($notification['type'], ['Wishlist', 'ShoppingCart']))
                                        <p><strong>Game:</strong> 
                                            @if(isset($notification['parsedDetails']['game_id']))
                                                <a href="{{ route('game.details', ['id' => $notification['parsedDetails']['game_id']]) }}">
                                                    {{ $notification['parsedDetails']['game_name'] ?? 'Unknown Game' }}
                                                </a>
                                            @else
                                                {{ $notification['parsedDetails']['game_name'] ?? 'Unknown Game' }}
                                            @endif
                                        </p>
                                        @if($notification['parsedDetails']['specific_type'] === 'Price')
                                            <p><strong>Old Price:</strong> €{{ $notification['parsedDetails']['old_price'] ?? 'N/A' }}</p>
                                            <p><strong>New Price:</strong> €{{ $notification['parsedDetails']['new_price'] ?? 'N/A' }}</p>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-links">
                {{ $notifications->links() }}
            </div>
        @endif
    @elseif(auth_user()->seller)
        @if($notifications->isEmpty())
            <div class="no-notifications">
                You have no notifications at the moment.
            </div>
        @else
            <div class="notifications">
                @foreach ($notifications as $notification)
                    <div class="notification" data-id="{{ $notification['id'] }}" data-type="{{ $notification['type'] }}">
                        <div class="notification-card">
                            <div class="notification-header">
                                @if(in_array($notification['type'], ['Game', 'Review']))
                                    <h5 class="notification-title">
                                        @if($notification['type'] === 'Game')
                                            <a href="{{ route('seller.products') }}" class="notification-title-link">
                                                {{ $notification['title'] }}
                                            </a>
                                        @elseif($notification['type'] === 'Review')
                                            @if(isset($notification['parsedDetails']['game_id']))
                                                <a href="{{ route('game.details', ['id' => $notification['parsedDetails']['game_id']]) }}" class="notification-title-link">
                                                    {{ $notification['title'] }}
                                                </a>
                                            @else
                                                {{ $notification['title'] }}
                                            @endif
                                        @endif
                                    </h5>
                                @else
                                    <h5 class="notification-title">{{ $notification['title'] }}</h5>
                                @endif
                                <button class="delete-notification-button" data-id="{{ $notification['id'] }}" aria-label="Delete notification">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="notification-body">
                                <p class="notification-text">{{ $notification['description'] }}</p>
                                <small class="notification-time">
                                    {{ (new \DateTime($notification['time']))->format('F d Y, H:i') }}
                                </small>
                                @if(!$notification['is_read'])
                                    <span class="unread-notification-indicator"></span>
                                @endif
                                <button class="view-notification-details" type="button" data-toggle="collapse" data-target="#details-{{ $notification['id'] }}" aria-expanded="false" aria-controls="details-{{ $notification['id'] }}">
                                    @if($notification['type'] === 'Game' || $notification['type'] === 'Review')
                                        View Details
                                    @endif
                                </button>
                            </div>
                            <div class="notifications-collapse collapse" id="details-{{ $notification['id'] }}">
                                <div class="notification-details">
                                    @if($notification['type'] === 'Game')
                                        <p><strong>Game:</strong> 
                                            @if(isset($notification['gameId']))
                                                <a href="{{ route('game.details', ['id' => $notification['gameId']]) }}">
                                                    {{ $notification['parsedDetails']['game_name'] ?? 'Unknown Game' }}
                                                </a>
                                            @else
                                                {{ $notification['parsedDetails']['game_name'] ?? 'Unknown Game' }}
                                            @endif
                                        </p>
                                        <p><strong>Quantity:</strong> {{ $notification['parsedDetails']['quantity'] ?? 'N/A' }}</p>
                                        @php
                                            $quantity = $notification['parsedDetails']['quantity'] ?? 0;
                                            $totalPrice = $notification['parsedDetails']['total_price'] ?? 0.0;
                                            $unitPrice = ($quantity > 0) ? $totalPrice / $quantity : 0.0;
                                        @endphp
                                        <p><strong>Unit Price:</strong> €{{ number_format($unitPrice, 2) }}</p>
                                        <p><strong>Total Price:</strong> €{{ number_format($totalPrice, 2) }}</p>
                                    @elseif($notification['type'] === 'Review')
                                        <p><strong>Game:</strong> 
                                            @if(isset($notification['parsedDetails']['game_id']))
                                                <a href="{{ route('game.details', ['id' => $notification['parsedDetails']['game_id']]) }}">
                                                    {{ $notification['parsedDetails']['game_name'] ?? 'Unknown Game' }}
                                                </a>
                                            @else
                                                {{ $notification['parsedDetails']['game_name'] ?? 'Unknown Game' }}
                                            @endif
                                        </p>
                                        <p><strong>Author:</strong> {{ $notification['parsedDetails']['review_author'] ?? 'Unknown Author' }}</p>
                                        <p><strong>Rating:</strong> {{ $notification['parsedDetails']['review_type'] ?? 'Unknown' }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-links">
                {{ $notifications->links() }}
            </div>
        @endif
    @endif
</div>
@endsection







