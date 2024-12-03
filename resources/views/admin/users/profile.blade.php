@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<h1>Profile</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<p><strong>User ID:</strong> {{ $user->id }}</p>
@php
    $profilePicture = $user->profile_picture ? asset($user->profile_picture) : asset('images/profile_pictures/default-profile-picture.png');
@endphp
<img src="{{ $profilePicture }}" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
        
<p><strong>Username:</strong> {{ $user->username }} <button onclick="document.getElementById('change-username-form').submit();">Change Innapropriate Username</button></p>
<p><strong>Name:</strong> {{ $user->name }} <button onclick="document.getElementById('change-name-form').submit();">Change Innapropriate Name</button></p>
<p><strong>Email:</strong> {{ $user->email }}</p>
<p><strong>Status:</strong>
    @if (!$user->is_active)
        Disabled
    @elseif ($user->is_blocked)
        Blocked
    @else
        Active
    @endif
</p>
@if ($user->buyer)
    <p><strong>Role:</strong> Buyer</p>
    <p><strong>NIF:</strong> {{ $user->buyer->nif ?? 'NONE' }}</p>
    <p><strong>Birth Date:</strong> {{ $user->buyer->birth_date }}</p>
    <p><strong>Coins:</strong> 
        {{ $user->buyer->coins }}
        @if ($user->is_active)
            <form id="change-coins-form" method="POST" action="{{ route('admin.users.changeCoins', $user->id) }}" style="display: inline;">
                {{ csrf_field() }}
                <input type="number" name="coins" value="{{ $user->buyer->coins }}" style="width: 100px;">
                <button type="submit">Change Coins</button>
            </form>
        @endif
        @if ($errors->has('coins'))
            <span class="error">
                {{ $errors->first('coins') }}
            </span>
        @endif
    </p>
@elseif ($user->seller)
    <p><strong>Role:</strong> Seller</p>
    <p><strong>Seller Information:</strong> This user is a seller.</p>
@endif

@if ($user->is_active)
    <form id="change-username-form" method="POST" action="{{ route('admin.users.changeUsername', $user->id) }}">
        {{ csrf_field() }}
    </form>

    <form id="change-name-form" method="POST" action="{{ route('admin.users.changeName', $user->id) }}">
        {{ csrf_field() }}
    </form>

    @if ($user->is_blocked)
        <form id="unblock-user-form" method="POST" action="{{ route('admin.users.unblock', $user->id) }}">
            {{ csrf_field() }}
            <button type="submit" onclick="return confirm('Are you sure you want to unblock this user?');">Unblock User</button>
        </form>
    @else
        <form id="block-user-form" method="POST" action="{{ route('admin.users.block', $user->id) }}">
            {{ csrf_field() }}
            <button type="submit" onclick="return confirm('Are you sure you want to block this user?');">Block User</button>
        </form>
    @endif

    <form id="deactivate-user-form" method="POST" action="{{ route('admin.users.deactivate', $user->id) }}">
        {{ csrf_field() }}
        <button type="submit" onclick="return confirm('Are you sure you want to deactivate this user?');">Deactivate User</button>
    </form>
@endif

@endsection