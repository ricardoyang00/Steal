@extends('layouts.app')

@section('content')

@if (session('success'))
    <p class="success">
        {{ session('success') }}
    </p>
@endif

@if ($errors->any())
    <div class="error">
        {{ $errors->first() }}
    </div>
@endif

<div class="form-container login-page">

<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <h1>Sign In</h1>

    <div class="input-wrapper">
        <input id="email" type="text" name="email" value="{{ old('email') }}" required>
        <label for="email" class="placeholder">E-mail</label>
    </div>

    <div class="input-wrapper">
        <input id="password" type="password" name="password" required>
        <label for="password" class="placeholder">Password</label>
    </div>

    <div class="checkbox-wrapper">
        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label for="remember">Remember Me</label>
    </div>
    
    <a class="google-button" href="{{ route('google-auth') }}">
        <img src="{{ asset('images/google-icon.svg') }}" alt="google logo" width="20px" height="auto"> Sign in with Google
    </a>
    
    <button type="submit">Login</button>

    <a class="button button-outline" href="{{ route('register') }}">Register</a>

    <a class="forgot-password">Forgot Your Password?</a>
</form>

</div>

@endsection