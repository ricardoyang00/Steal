@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<script src="{{ asset('js/profile/profile.js') }}" defer></script>

<section id="profile" style="display: {{ $errors->any() ? 'none' : 'block' }};">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <article>
        <h1>Profile</h1>
        @php
            $profilePicture = auth_user()->profile_picture ? asset(auth_user()->profile_picture) : asset('images/profile_pictures/default-profile-picture.png');
        @endphp
        <img src="{{ $profilePicture }}" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
        
        <p><strong>Username:</strong> {{ auth_user()->username }}</p>
        <p><strong>Name:</strong> {{ auth_user()->name }}</p>
        <p><strong>Email:</strong> {{ auth_user()->email }}</p>

        @if (auth_user()->buyer)
            <p><strong>NIF:</strong> {{ auth_user()->buyer->nif ?? 'NONE'}}</p>
            <p><strong>Birth Date:</strong> {{ auth_user()->buyer->birth_date }}</p>
            <p><strong>Coins:</strong> {{ auth_user()->buyer->coins }}</p>
        @elseif (auth_user()->seller)
            <p><strong>Seller Information:</strong> This user is a seller.</p>
        @elseif (is_admin())
            <p><strong>Admin Information:</strong> This user is an admin.</p>
        @endif

        <button id="edit-profile-btn">Edit</button>
        @if (auth_user()->buyer && auth_user()->google_id === null)
            <button id="change-password-btn">Change Password</button>
        @endif

        <!-- Deactivate Account Button -->
        @if (!is_admin())    
            <form method="POST" action="{{ route('profile.deactivate') }}">
                {{ csrf_field() }}
                <button type="submit" onclick="return confirm('Are you sure you want to deactivate your account? Please note that all your data will be anonymized as part of this process.');">Deactivate Account</button>
            </form>
        @endif
    </article>
</section>

<!-- Edit Profile -->
<section id="edit-profile" style="display: {{ $errors->any() && !$errors->has('current_password') && !$errors->has('new_password') && !$errors->has('new_password_confirmation') ? 'block' : 'none' }};">
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        @method('PUT')
        <label for="profile_picture">Profile Picture:</label>
        <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
        @if ($errors->has('profile_picture'))
            <span class="error">
                {{ $errors->first('profile_picture') }}
            </span>
        @endif

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="{{ auth_user()->username }}">
        @if ($errors->has('username'))
            <span class="error">
                {{ $errors->first('username') }}
            </span>
        @endif

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ auth_user()->name }}">
        @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
        @endif

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ auth_user()->email }}" readonly>
        
        @if (auth_user()->buyer)
            <label for="nif">NIF:</label>
            <input type="text" id="nif" name="nif" value="{{ auth_user()->buyer->nif }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="9">    
            @if ($errors->has('nif'))
                <span class="error">
                    {{ $errors->first('nif') }}
                </span>
            @endif

            <label for="birth_date">Birth Date:</label>
            <input type="date" id="birth_date" name="birth_date" value="{{ auth_user()->buyer->birth_date }}" readonly>
            
            <label for="coins">Coins:</label>
            <input type="number" id="coins" name="coins" value="{{ auth_user()->buyer->coins }}" readonly>
        @endif
        
        <button type="button" id="cancel-edit-btn">Cancel</button>
        <button type="submit">Save</button>
    </form>
</section>

<!-- Change Password -->
<div id="change-password" style="display: {{ $errors->has('current_password') || $errors->has('new_password') || $errors->has('new_password_confirmation') ? 'block' : 'none' }};">
    <form method="POST" action="{{ route('profile.updatePassword') }}">
        {{ csrf_field() }}
        @method('PUT')
        <label for="current_password">Current Password:</label>
        <input type="password" id="current_password" name="current_password" required>
        @if ($errors->has('current_password'))
            <span class="error">
                {{ $errors->first('current_password') }}
            </span>
        @endif

        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required>
        @if ($errors->has('new_password'))
            <span class="error">
                {{ $errors->first('new_password') }}
            </span>
        @endif

        <label for="new_password_confirmation">Confirm New Password:</label>
        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>
        
        <button type="button" id="cancel-change-password-btn">Cancel</button>
        <button type="submit">Change Password</button>
    </form>
</div>

@endsection