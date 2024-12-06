@php
    use Illuminate\Support\Facades\Storage;
@endphp

@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<script src="{{ asset('js/profile/profile.js') }}" defer></script>
<script src="{{ asset('js/common/confirmation-modal.js') }}" defer></script>
<script src="{{ asset('js/common/toggle-password.js') }}" defer></script>
@include('partials.common.confirmation-modal')

@php
    $profilePicturePath = auth_user()->profile_picture;
    $profilePictureFullPath = public_path($profilePicturePath);
    $profilePicture = auth_user()->profile_picture && file_exists($profilePictureFullPath) 
        ? asset($profilePicturePath) 
        : asset('images/profile_pictures/default-profile-picture.png');
@endphp

<section id="profile" style="display: {{ $errors->any() ? 'none' : 'flex' }};">
    <div class="profile-card">
        <!-- Username -->
        <div class="profile-username">
            <strong>{{ auth_user()->username }}</strong>
        </div>

        <!-- Profile Picture -->
        <div class="profile-picture">
            <img src="{{ $profilePicture }}" alt="Profile Picture">
        </div>
        
        <!-- Profile Details -->
        <div class="profile-details">
            <div class="detail-box">
                <div class="detail-label"><strong>Name</strong></div>
                <div class="detail-info">{{ auth_user()->name }}</div>
            </div>
            <div class="detail-box">
                <div class="detail-label"><strong>Email</strong></div>
                <div class="detail-info">{{ auth_user()->email }}</div>
            </div>

            @if (auth_user()->buyer)
                <div class="detail-box">
                    <div class="detail-label"><strong>NIF</strong></div>
                    <div class="detail-info">{{ auth_user()->buyer->nif ?? 'NONE'}}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label"><strong>Birth Date</strong></div>
                    <div class="detail-info">{{ auth_user()->buyer->birth_date }}</div>
                </div>
                <div class="detail-box">
                    <div class="detail-label"><strong>Coins</strong></div>
                    <div class="detail-info">{{ auth_user()->buyer->coins }}</div>
                </div>
            @elseif (auth_user()->seller)
                <div class="detail-box">
                    <div class="detail-label"><strong>Seller Information</strong></div>
                    <div class="detail-info">This user is a seller.</div>
                </div>
            @elseif (is_admin())
                <div class="detail-box">
                    <div class="detail-label"><strong>Admin Information</strong></div>
                    <div class="detail-info">This user is an admin.</div>
                </div>
            @endif
        </div>

        <!-- Buttons -->
        <div class="profile-actions">
            <button id="edit-profile-btn">
                <i class="fas fa-edit"></i> Edit profile
            </button>
            @if (auth_user()->google_id === null)
                <button id="change-password-btn">
                    <i class="fas fa-key"></i> Change Password
                </button>
            @endif
            
            @if (!is_admin())
                <form method="POST" action="{{ route('profile.deactivate') }}" id="deactivate-account-form" class="deactivate-form">
                    {{ csrf_field() }}
                    <button type="button" id="delete-account-btn" class="confirmation-btn" 
                            data-title="Are you sure you want to delete your account?"
                            data-message="Please note that this action is irreversible and all your data will be anonymized as part of this process."
                            data-form-id="deactivate-account-form">
                        Delete Account
                    </button>
                </form>
            @endif
        </div>
    </div>
</section>

<!-- Edit Profile -->
<section id="edit-profile" style="display: {{ $errors->any() && !$errors->has('current_password') && !$errors->has('new_password') && !$errors->has('new_password_confirmation') ? 'flex' : 'none' }};">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')

        <div class="profile-card">
            <!-- Profile Picture -->
            <div class="profile-picture">
                <img src="{{ $profilePicture }}" alt="Profile Picture" id="editable-profile-picture">
                <div class="edit-icon" id="edit-icon">
                    <i class="fas fa-pen"></i>
                </div>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" style="display: none;">
                @if ($errors->has('profile_picture'))
                    <span class="error">
                        {{ $errors->first('profile_picture') }}
                    </span>
                @endif
            </div>

            <!-- Profile Details -->
            <div class="profile-details">
                <div class="detail-box editable">
                    <div class="detail-label"><label for="username"><strong>Username</strong></label></div>
                    <div class="detail-info"><input type="text" id="username" name="username" value="{{ auth_user()->username }}" minlength="5" maxlength="15"></div>
                    @if ($errors->has('username'))
                        <span class="error">
                            {{ $errors->first('username') }}
                        </span>
                    @endif
                </div>
                <div class="detail-box editable">
                    <div class="detail-label"><label for="name"><strong>Name</strong></label></div>
                    <div class="detail-info"><input type="text" id="name" name="name" value="{{ auth_user()->name }}" minlength="5" maxlength="30"></div>
                    @if ($errors->has('name'))
                        <span class="error">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                </div>
                <div class="detail-box">
                    <div class="detail-label"><strong>Email</strong></div>
                    <div class="detail-info">{{ auth_user()->email }}</div>
                </div>

                @if (auth_user()->buyer)
                    <div class="detail-box editable">
                        <div class="detail-label"><label for="nif"><strong>NIF</strong></label></div>
                        <div class="detail-info"><input type="text" id="nif" name="nif" value="{{ auth_user()->buyer->nif }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="9"></div>
                        @if ($errors->has('nif'))
                            <span class="error">
                                {{ $errors->first('nif') }}
                            </span>
                        @endif
                    </div>
                    <div class="detail-box">
                        <div class="detail-label"><strong>Birth Date</strong></div>
                        <div class="detail-info">{{ auth_user()->buyer->birth_date }}</div>
                    </div>
                    <div class="detail-box">
                        <div class="detail-label"><strong>Coins</strong></div>
                        <div class="detail-info">{{ auth_user()->buyer->coins }}</div>
                    </div>
                @endif
            </div>

            <!-- Buttons -->
            <div class="profile-actions">
                <button type="button" id="cancel-edit-btn">Cancel</button>
                <button type="submit" id="save-edit-btn">Save</button>
            </div>
        </div>
    </form>
</section>

<!-- Change Password -->
<div id="change-password" style="display: {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation') ? 'block' : 'none' }};">
    <form method="POST" action="{{ route('profile.updatePassword') }}">
        {{ csrf_field() }}
        @method('PUT')

        <div class="profile-card-password">
            <!-- Username -->
            <div class="profile-username">
                <strong>{{ auth_user()->username }}</strong>
            </div>
    
            <!-- Profile Picture -->
            <div class="profile-picture">
                <img src="{{ $profilePicture }}" alt="Profile Picture">
            </div>
            
            <!-- Profile Details -->
            <div class="profile-details">
                <div class="detail-box">
                    <div class="detail-label" id="password-label"><label for="current_password"><strong>Current Password</strong></label></div>
                    <div class="detail-info">
                        <input type="password" id="current_password" name="current_password" required maxlength="25">
                        <i class="fas fa-eye toggle-password" data-toggle="#current_password"></i>
                    </div>
                </div>
                <div class="detail-box">
                    <div class="detail-label" id="password-label"><label for="new_password"><strong>New Password</strong></label></div>
                    <div class="detail-info">
                        <input type="password" id="new_password" name="new_password" required minlength="8" maxlength="25">
                        <i class="fas fa-eye toggle-password" data-toggle="#new_password"></i>
                    </div>
                </div>
                <div class="detail-box">
                    <div class="detail-label" id="password-label"><label for="new_password_confirmation"><strong>Confirm New Password</strong></label></div>
                    <div class="detail-info">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required minlength="8" maxlength="25">
                        <i class="fas fa-eye toggle-password" data-toggle="#new_password_confirmation"></i>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="profile-actions">
                <button type="button" id="cancel-change-password-btn">Cancel</button>
                <button type="submit" id="confirm-change-password-btn">Confirm Change</button>
            </div>
        </div>
    </form>
</div>

@endsection