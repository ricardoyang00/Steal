@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<script src="{{ asset('js/notifications/notifications.js') }}" defer></script>
<script src="{{ asset('js/notifications/notifications-buttons.js') }}" defer></script>
<div id="notifications-tab" class="notifications-container">
    <h1>Notifications</h1>

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
                            <h5 class="notification-title">{{ $notification['title'] }}</h5>
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
                                {{ in_array($notification['type'], ['Wishlist', 'ShoppingCart']) ? 'View Details' : 'View Order Details' }}
                            </button>
                        </div>
                        <div class="notifications-collapse collapse" id="details-{{ $notification['id'] }}">
                            <div class="notification-details">
                                @if($notification['type'] === 'Order')
                                    <p><strong>Placed at:</strong> {{ $notification['orderDetails']['date'] }}</p>
                                    @php
                                        $purchasedGames = collect($notification['orderDetails']['purchases'])->filter(fn($purchase) => $purchase['type'] === 'Delivered');
                                    @endphp
                                    @if($purchasedGames->isNotEmpty())
                                        <h6>Purchased Games:</h6>
                                        <ul>
                                            @foreach($notification['orderDetails']['purchases'] as $purchase)
                                                @if($purchase['type'] === 'Delivered')
                                                    <li>{{ $purchase['gameName'] }} - ${{ $purchase['value'] }}</li>
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
                                                    <li>{{ $purchase['gameName'] }} - ${{ $purchase['value'] }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                    <p><strong>Total Price:</strong> ${{ $notification['orderDetails']['totalPrice'] ?? 0.0 }}</p>
                                @elseif(in_array($notification['type'], ['Wishlist', 'ShoppingCart']))
                                    <p><strong>Game:</strong> {{ $notification['parsedDetails']['game_name'] ?? 'Unknown Game' }}</p>
                                    @if($notification['parsedDetails']['specific_type'] === 'Price')
                                        <p><strong>Old Price:</strong> ${{ $notification['parsedDetails']['old_price'] ?? 'N/A' }}</p>
                                        <p><strong>New Price:</strong> ${{ $notification['parsedDetails']['new_price'] ?? 'N/A' }}</p>
                                    @elseif($notification['parsedDetails']['specific_type'] === 'Stock')
                                        <p><strong>Update:</strong> {{ $notification['description'] }}</p>
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
</div>
@endsection





