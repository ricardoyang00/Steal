@extends('layouts.app')

@section('title', 'Profile')

@section('content')

<section id="profile">
    <article>
        <h1>Profile</h1>
        <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
        <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
        
        @if (Auth::user()->buyer)
            <p><strong>NIF:</strong> {{ Auth::user()->buyer->nif }}</p>
            <p><strong>Birth Date:</strong> {{ Auth::user()->buyer->birth_date }}</p>
            <p><strong>Coins:</strong> {{ Auth::user()->buyer->coins }}</p>
        @elseif (Auth::user()->seller)
            <p><strong>Seller Information:</strong> This user is a seller.</p>
        @endif
    </article>
</section>

@endsection