@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<section id="profile" style="display: {{ $errors->any() ? 'none' : 'block' }};">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <article>
        <h1>Profile</h1>
        <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>

        @if (Auth::user()->buyer)
            <p><strong>NIF:</strong> {{ Auth::user()->buyer->nif ?? 'NONE'}}</p>
            <p><strong>Birth Date:</strong> {{ Auth::user()->buyer->birth_date }}</p>
            <p><strong>Coins:</strong> {{ Auth::user()->buyer->coins }}</p>
        @elseif (Auth::user()->seller)
            <p><strong>Seller Information:</strong> This user is a seller.</p>
        @endif

        <button id="edit-profile-btn">Edit</button>
        <button id="change-password-btn">Change Password</button>
    </article>
</section>

<!-- Edit Profile -->
<section id="edit-profile" style="display: {{ $errors->any() && !$errors->has('current_password') && !$errors->has('new_password') && !$errors->has('new_password_confirmation') ? 'block' : 'none' }};">
    <form method="POST" action="{{ route('profile.update') }}">
        {{ csrf_field() }}
        @method('PUT')
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="{{ Auth::user()->username }}">
        @if ($errors->has('username'))
            <span class="error">
                {{ $errors->first('username') }}
            </span>
        @endif

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}">
        @if ($errors->has('name'))
            <span class="error">
                {{ $errors->first('name') }}
            </span>
        @endif

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" readonly>
        
        @if (Auth::user()->buyer)
            <label for="nif">NIF:</label>
            <input type="text" id="nif" name="nif" value="{{ Auth::user()->buyer->nif }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="9">    
            @if ($errors->has('nif'))
                <span class="error">
                    {{ $errors->first('nif') }}
                </span>
            @endif

            <label for="birth_date">Birth Date:</label>
            <input type="date" id="birth_date" name="birth_date" value="{{ Auth::user()->buyer->birth_date }}" readonly>
            
            <label for="coins">Coins:</label>
            <input type="number" id="coins" name="coins" value="{{ Auth::user()->buyer->coins }}" readonly>
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

<script>
    function clearErrors() {
        const errorElements = document.querySelectorAll('.error');
        errorElements.forEach(element => {
            element.innerHTML = '';
        });
    }

    document.getElementById('edit-profile-btn').addEventListener('click', function() {
        document.getElementById('profile').style.display = 'none';
        document.getElementById('edit-profile').style.display = 'block';
    });

    document.getElementById('cancel-edit-btn').addEventListener('click', function() {
        clearErrors();
        document.getElementById('edit-profile').style.display = 'none';
        document.getElementById('profile').style.display = 'block';
    });

    document.getElementById('change-password-btn').addEventListener('click', function() {
        document.getElementById('profile').style.display = 'none';
        document.getElementById('change-password').style.display = 'block';
    });

    document.getElementById('cancel-change-password-btn').addEventListener('click', function() {
        clearErrors();
        document.getElementById('change-password').style.display = 'none';
        document.getElementById('profile').style.display = 'block';
    });
</script>

@endsection