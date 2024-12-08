@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')

<div class="password-reset-form">
    <h1>Forgot Your Password?</h1>
    <p>Enter your email address, and we’ll send you a link to reset your password.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required autofocus>
        </div>
        <button type="submit">Send Reset Link</button>
    </form>
</div>

@endsection
