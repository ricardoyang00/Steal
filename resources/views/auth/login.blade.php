@extends('layouts.app')

@section('content')

@if (session('success'))
    <p class="success">
        {{ session('success') }}
    </p>
@endif

<div class="form-container login-page">

<form method="POST" action="{{ route('login') }}">
    {{ csrf_field() }}

    <h1>Sign In</h1>

    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
    @if ($errors->has('email'))
        <span class="error">
            {{ $errors->first('email') }}
        </span>
    @endif

    <label for="password" >Password</label>
    <input id="password" type="password" name="password" required placeholder="Password">
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif
    
    <label>
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
    </label>
    
    <button type="submit">
        Login
    </button>
    <a class="button button-outline" href="{{ route('register') }}">Register</a>
    <a>Forgot Your Password?</a>
</form>

</div>

@endsection