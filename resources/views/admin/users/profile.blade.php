@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<script src="{{ asset('js/admin/user-profile.js') }}" defer></script>
<script src="{{ asset('js/common/confirmation-modal.js') }}" defer></script>
@include('partials.common.confirmation-modal')

@php
    $profilePicturePath = $user->profile_picture;
    $profilePictureFullPath = public_path($profilePicturePath);
    $profilePicture = $user->profile_picture && file_exists($profilePictureFullPath) 
        ? asset($profilePicturePath) 
        : asset('images/profile_pictures/default-profile-picture.png');
@endphp

<div id="admin-check-user-profile" style="display: flex; justify-content: center">
    <div class="profile-card-admin-view">
        <!-- Profile Picture -->
        <div class="profile-picture-admin-view">
            <img src="{{ $profilePicture }}" alt="Profile Picture" id="editable-profile-picture">
            @if ($user->is_active)
                <form method="POST" action="{{ route('admin.users.resetPicture', $user->id) }}" id="reset-profile-picture-form">
                    @csrf
                    @method('PUT')
                    <button type="button" id="reset-profile-picture-btn" class="confirmation-btn"
                            data-title="Reset Profile Picture to Default"
                            data-message="Are you sure you want to reset this profile picture?"
                            data-form-id="reset-profile-picture-form">
                        <i class="fas fa-undo"></i> Reset to Default
                    </button>
                </form>
            @endif
        </div>

        <!-- Profile Details -->
        <div class="profile-details">
            <div class="detail-box">
                <div class="detail-label"><strong>User ID</strong></div>
                <div class="detail-info">{{ $user->id }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><strong>Username</strong></div>
                <div class="detail-info">
                    {{ $user->username }}
                    @if ($user->is_active)
                    <form id="change-username-form" method="POST" action="{{ route('admin.users.changeUsername', $user->id) }}">
                        @csrf
                        <button type="button" id="change-button" class="confirmation-btn"
                                data-title="Change Username"
                                data-message="Are you sure you want to change this user's username?"
                                data-form-id="change-username-form">
                            Change
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><strong>Name</strong></div>
                <div class="detail-info">
                    {{ $user->name }}
                    @if ($user->is_active)
                        <form id="change-name-form" method="POST" action="{{ route('admin.users.changeName', $user->id) }}">
                            @csrf
                            <button type="button" id="change-button" class="confirmation-btn"
                                    data-title="Change Name"
                                    data-message="Are you sure you want to change this user's ame?"
                                    data-form-id="change-name-form">
                                Change
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><strong>Email</strong></div>
                <div class="detail-info">{{ $user->email }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><strong>Status</strong></div>
                <div class="detail-info" id="status-info">
                    @if (!$user->is_active)
                        Disabled
                    @elseif ($user->is_blocked)
                        Blocked
                    @else
                        Active
                    @endif
                </div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><strong>Role</strong></div>
                <div class="detail-info">
                    @if ($user->buyer)
                        Buyer
                    @elseif ($user->seller)
                        Seller
                    @endif
                </div>
            </div>
            @if ($user->buyer)
                <div class="detail-box">
                    <div class="detail-label"><strong>NIF</strong></div>
                    <div class="detail-info">{{ $user->buyer->nif ?? 'NONE' }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label"><strong>Birth Date</strong></div>
                    <div class="detail-info">{{ $user->buyer->birth_date }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label"><strong>Coins</strong></div>
                    <div class="detail-info">
                        <span id="coins-display">{{ $user->buyer->coins }}</span>
                        @if ($user->is_active)
                            <button type="button" id="edit-coins-btn" class="edit-button">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form id="change-coins-form" method="POST" action="{{ route('admin.users.changeCoins', $user->id) }}" style="display: none; margin-left: 10px;">
                                @csrf
                                <input type="number" name="coins" value="{{ $user->buyer->coins }}">
                                <button type="button" id="cancel-change-coins-btn">Cancel</button>
                                <button type="submit" id="confirm-change-coins-btn">Confirm</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Buttons -->
            <div class="profile-actions">
                @if ($user->is_active)
                    @if ($user->is_blocked)
                        <form id="unblock-user-form" method="POST" action="{{ route('admin.users.unblock', $user->id) }}">
                            @csrf
                            <button type="button" class="confirmation-btn" id="block-unblock-btn" data-title="Unblock User" data-message="Are you sure you want to unblock this user?" data-form-id="unblock-user-form">Unblock User</button>
                        </form>
                    @else
                        <form id="block-user-form" method="POST" action="{{ route('admin.users.block', $user->id) }}">
                            @csrf
                            <button type="button" class="confirmation-btn" id="block-unblock-btn" data-title="Block User" data-message="Are you sure you want to block this user?" data-form-id="block-user-form">Block User</button>
                        </form>
                    @endif

                    <form id="deactivate-user-form" method="POST" action="{{ route('admin.users.deactivate', $user->id) }}">
                        @csrf
                        <button type="button" class="confirmation-btn" id="deactivate-btn" data-title="Deactivate User" data-message="Are you sure you want to deactivate this user? This action is irreversible and all data will be anonymized, be careful!" data-form-id="deactivate-user-form">Deactivate User</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
    
@endsection