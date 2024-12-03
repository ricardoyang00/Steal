@extends('layouts.app')

@section('title', 'Notifications')

@section('content')

<script src="{{ asset('js/notifications/notifications.js') }}" defer></script>
<div id = "notifications-tab" class="notifications-container">
    <h1>My Notifications</h1>

    @if(empty($notifications))
        <div class="no-notifications">
            You have no notifications at the moment.
        </div>
    @else
        <ul class="notifications-list">
            @foreach ($notifications as $notification)
                <li class="notification">
                    <div class="notification-details">
                        <div class="notification-title">{{ $notification['title'] }}</div>
                        <p class="notification-description">{{ $notification['description'] }}</p>
                        <small class="notification-time">
                            {{ \Carbon\Carbon::parse($notification['time'])->format('F j, Y, g:i a') }}
                        </small>
                    </div>
                    @if(!$notification['is_read'])
                        <span class="unread-notification">New</span>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="pagination-links">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
