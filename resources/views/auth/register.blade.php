@extends('layouts.app')

@section('content')

<script src="{{ asset('js/register/register.js') }}" defer></script>

<div class="form-container register">

<form method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}

    <label for="user_type">
      {{ is_admin() ? 'Create' : 'Register as' }}
    </label>
    <select id="user_type" name="user_type" required>
        <option value="buyer" {{ old('user_type') == 'buyer' ? 'selected' : '' }}>Buyer</option>
        <option value="seller" {{ old('user_type') == 'seller' ? 'selected' : '' }}>Seller</option>
        @if (is_admin())
          <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
        @endif
    </select>
    @if ($errors->has('user_type'))
      <span class="error">
          {{ $errors->first('user_type') }}
      </span>
    @endif

    <label for="username">Username</label>
    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
      <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <label for="name">Name</label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
    @if ($errors->has('name'))
      <span class="error">
          {{ $errors->first('name') }}
      </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif
    
    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <div id="buyer_fields">
        <label for="birth_date">Birth Date</label>
        <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}">
        @if ($errors->has('birth_date'))
          <span class="error">
              {{ $errors->first('birth_date') }}
          </span>
        @endif
    </div>

    <button type="submit">
      {{ is_admin() ? 'Create' : 'Register' }}
    </button>
</form>

</div>

@endsection