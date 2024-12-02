@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="notifications-container">
    <h1>My Notifications</h1>

    @if($notifications->isEmpty())
        <div class="no-notifications">
            You have no notifications at the moment.
        </div>
    @else
        <ul class="notifications-list">
            @foreach ($notifications as $notification)
                <li class="notification">
                    <div class="notification-details">
                        <div class="notification-title">{{ $notification->title }}</div>
                        <p class="notification-description">{{ $notification->description }}</p>
                        <small class="notification-time">{{ $notification->time->format('F j, Y, g:i a') }}</small>
                    </div>
                    @if(!$notification->isRead)
                        <span class="unread-notification">New</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
