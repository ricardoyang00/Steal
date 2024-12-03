@extends('layouts.app')

@section('content')

<script src="{{ asset('js/register/register.js') }}" defer></script>

@if ($errors->any())
    <div class="error">
        {{ $errors->first() }}
    </div>
@endif

<div class="form-container register-page">

<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <h1>Sign Up</h1>

    <select id="user_type" name="user_type" required>
        <option value="buyer" {{ old('user_type') == 'buyer' ? 'selected' : '' }}>Buyer</option>
        <option value="seller" {{ old('user_type') == 'seller' ? 'selected' : '' }}>Seller</option>
        @if (is_admin())
          <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
        @endif
    </select>
    
    <div class="input-wrapper">
      <input id="username" type="text" name="username" value="{{ old('username') }}" required minlength="5" maxlength="15">
      <label for="username" class="placeholder">Username</label>
    </div>

    <div class="input-wrapper">
      <input id="name" type="text" name="name" value="{{ old('name') }}" required minlength="5" maxlength="30">
      <label for="name" class="placeholder">Name</label>
    </div>
    
    <div class="input-wrapper">
      <input id="email" type="text" name="email" value="{{ old('email') }}" required>
      <label for="email" class="placeholder">E-mail</label>
    </div>
    
    <div class="input-wrapper">
      <input id="password" type="password" name="password" required minlength="8" maxlength="25">
      <label for="password" class="placeholder">Password</label>
    </div>
    
    <div class="input-wrapper">
      <input id="password-confirm" type="password" name="password_confirmation" required minlength="8" maxlength="25">
      <label for="password-confirm" class="placeholder">Confirm Password</label>
    </div>
    
    <div id="buyer_fields">
      <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}">
    </div>
    
    <a class="google-button" href="{{ route('google-auth') }}">
      <img src="{{ asset('images/google-icon.svg') }}" alt="google logo" width="20px" height="auto"> Sign up with Google
    </a>

    <button type="submit">
      {{ is_admin() ? 'Create' : 'Register' }}
    </button>

    <a class="button button-outline" href="{{ route('login') }}">Sign In</a>
</form>

</div>

@endsection