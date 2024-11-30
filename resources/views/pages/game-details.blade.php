@extends('layouts.app')

@section('title', $game->name)

@section('content')
<script src="{{ asset('js/cart/add-to-cart.js') }}" defer></script>

<div class="game-details-page">
    <div class="game-image">
        <img src="{{ asset('images/default-game-image.jpg') }}" class="img-fluid" alt="{{ $game->name }}">
    </div>
    <div class="game-details">
        <h1>{{ $game->name }}</h1>
        <p><strong>Description:</strong> {{ $game->description }}</p>
        <p><strong>Owner:</strong> {{ $game->seller->name }}</p>
        <p><strong>Minimum Age:</strong> {{ $game->minimum_age }}</p>
        <p><strong>Price:</strong> ${{ $game->price }}</p>
        <p><strong>Rating:</strong> {{ $game->overall_rating }}%</p>
        @if (!auth_user() || auth_user()->buyer)
            <button id="add-to-cart-{{ $game->id }}" data-id="{{ $game->id }}" class="btn-add-to-cart btn btn-primary">
                Add to Cart
            </button>
        @endif
    </div>
</div>

<p><strong>Available Platforms:</strong></p>
<ul>
    @foreach($game->platforms as $platform)
        <li>{{ $platform->name }}</li>
    @endforeach
</ul>

<p><strong>Categories:</strong></p>
<ul>
    @foreach($game->categories as $category)
        <li>{{ $category->name }}</li>
    @endforeach
</ul>

<p><strong>Languages:</strong></p>
<ul>
    @foreach($game->languages as $language)
        <li>{{ $language->name }}</li>
    @endforeach
</ul>

<p><strong>Players:</strong></p>
<ul>
    @foreach($game->players as $player)
        <li>{{ $player->name }}</li>
    @endforeach
</ul>

@endsection