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
    </article>
</section>

<section id="edit-profile" style="display: {{ $errors->any() ? 'block' : 'none' }};">
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

<script>
    document.getElementById('edit-profile-btn').addEventListener('click', function() {
        document.getElementById('profile').style.display = 'none';
        document.getElementById('edit-profile').style.display = 'block';
    });

    document.getElementById('cancel-edit-btn').addEventListener('click', function() {
        document.getElementById('edit-profile').style.display = 'none';
        document.getElementById('profile').style.display = 'block';
    });
</script>

@endsection