@extends('layouts.app')

@section('title', 'User Search Results')

@section('content')

<script src="{{ asset('js/admin/manage-users.js') }}" defer></script>

<div class="admin-user-index">
    <h1>Manage Users</h1>
    <form method="GET" action="{{ route('admin.users.search') }}">
        <div class="search-container">
            <input type="text" name="user_query" placeholder="Input username or email..." value="{{ request('user_query') }}">
            <button type="submit">Search</button>
        </div>
        <div class="filter-buttons">
            <button id="filter-user-search" type="submit" name="status" value="all" 
                class="{{ request('status') === 'all' ? 'active' : '' }}">All</button>
            <button id="filter-user-search" type="submit" name="status" value="active" 
                class="{{ request('status') === 'active' ? 'active' : '' }}">Active</button>
            <button id="filter-user-search" type="submit" name="status" value="blocked" 
                class="{{ request('status') === 'blocked' ? 'active' : '' }}">Blocked</button>
            <button id="filter-user-search" type="submit" name="status" value="disabled" 
                class="{{ request('status') === 'disabled' ? 'active' : '' }}">Disabled</button>
        </div>
        
    </form>

    <div class="list-buyers-sellers">
        <div class="user-list">
            <h2>Buyers</h2>
            @if ($buyers->isEmpty())
                <p>No buyers found.</p>
            @else
                <ul>
                    @foreach ($buyers as $buyer)
                        @php
                            $profilePicturePath = $buyer->profile_picture;
                            $profilePictureFullPath = public_path($profilePicturePath);
                            $profilePicture = $buyer->profile_picture && file_exists($profilePictureFullPath) 
                                ? asset($profilePicturePath) 
                                : asset('images/profile_pictures/default-profile-picture.png');
    
                            $status = 'Active';
                            if (!$buyer->is_active) {
                                $status = 'Disabled';
                            } elseif ($buyer->is_blocked) {
                                $status = 'Blocked';
                            }
                        @endphp
    
                        <li>
                            <a href="{{ route('admin.users.profile', $buyer->id) }}" class="user-card">
                                <div class="user-card-content {{ $status }}" id="user-{{ $buyer->id }}">
                                    <div class="avatar">
                                        <img src="{{ $profilePicture }}" alt="{{ $buyer->username }} profile picture">
                                    </div>
                                    <span class="username">{{ $buyer->username }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    
        <div class="user-list">
            <h2>Sellers</h2>
            @if ($sellers->isEmpty())
                <p>No sellers found.</p>
            @else
                <ul>
                    @foreach ($sellers as $seller)
                        @php
                            $profilePicturePath = $seller->profile_picture;
                            $profilePictureFullPath = public_path($profilePicturePath);
                            $profilePicture = $seller->profile_picture && file_exists($profilePictureFullPath) 
                                ? asset($profilePicturePath) 
                                : asset('images/profile_pictures/default-profile-picture.png');
    
                            $status = 'Active';
                            if (!$seller->is_active) {
                                $status = 'Disabled';
                            } elseif ($seller->is_blocked) {
                                $status = 'Blocked';
                            }
                        @endphp
    
                        <li>
                            <a href="{{ route('admin.users.profile', $seller->id) }}" class="user-card">
                                <div class="user-card-content {{ $status }}" id="user-{{ $seller->id }}">
                                    <div class="avatar">
                                        <img src="{{ $profilePicture }}" alt="{{ $seller->username }} profile picture">
                                    </div>
                                    <span class="username">{{ $seller->username }}</span>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

@endsection