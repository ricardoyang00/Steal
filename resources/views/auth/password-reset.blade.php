@extends('layouts.app')

@section('title', 'Password Reset')

@section('content')

<script src="{{ asset('js/common/toggle-password.js') }}" defer></script>

<div class="password-reset-form">
    <h1>Reset Your Password</h1>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        
        <div class="input-wrapper-password">
            <label for="email" class="placeholder">Email</label>
            <div class="password-container">
                <input type="text" name="email_display" id="email" value="{{ $email }}" readonly>
            </div>
        </div>
        
        <div class="input-wrapper-password">
            <label for="password">New Password</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required minlength="8" maxlength="25">
                <i class="fas fa-eye toggle-password" data-toggle="#password"></i>
            </div>
        </div>
        <div class="input-wrapper-password">
            <label for="password_confirmation">Confirm New Password</label>
            <div class="password-container">
                <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" maxlength="25">
                <i class="fas fa-eye toggle-password" data-toggle="#password_confirmation"></i>
            </div>
        </div>
        <button type="submit">Reset Password</button>
    </form>
</div>

@endsection
