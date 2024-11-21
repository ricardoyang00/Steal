@extends('layouts.app')

@section('title', $game->name)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/default-game-image.jpg') }}" class="img-fluid" alt="{{ $game->name }}">
        </div>
        <div class="col-md-6">
            <h1>{{ $game->name }}</h1>
            <p><strong>Description:</strong> {{ $game->description }}</p>
            <p><strong>Owner:</strong> {{ $game->seller->name }}</p>
            <p><strong>Minimum Age:</strong> {{ $game->minimum_age }}</p>
            <p><strong>Price:</strong> ${{ $game->price }}</p>
            <p><strong>Rating:</strong> {{ $game->overall_rating }}%</p>
            <a href="#" class="btn btn-primary">Buy Now</a>
        </div>
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