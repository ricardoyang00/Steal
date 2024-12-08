@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<script src="{{ asset('js/forgot_password/forgot-password.js') }}" defer></script>

<div class="password-forgot-form">
    <div class="form-container">
        <h1>Forgot Your Password?</h1>
        <p>Enter your email address, and we’ll send you a link to reset your password.</p>

        <form id="forgot-form" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div>
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required autofocus>
            </div>
            <button type="submit">Send Reset Link</button>
        </form>
    </div>

    <!-- Loading dots (hidden by default) -->
    <div id="loading" class="loading-dots">
        <span>.</span>
        <span>.</span>
        <span>.</span>
    </div>
</div>

@endsection
