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
    @foreach($game->gamePlatforms as $gamePlatform)
        @if($gamePlatform->platform)
            <li>{{ $gamePlatform->platform->name ?? 'If not displaying, something is wrong!' }} (id = {{ $gamePlatform->platform }})</li>
        @else
            <li>Platform Not Found</li>
        @endif
    @endforeach
</ul>

<p><strong>Categories:</strong></p>
<ul>
    @foreach($game->gameCategories as $gameCategory)
        @if($gameCategory->category)
            <li>{{ $gameCategory->category->name ?? 'If not displaying, something is wrong!' }} (id = {{ $gameCategory->category }})</li>
        @else
            <li>Category Not Found</li>
        @endif
    @endforeach
</ul>

<p><strong>Languages:</strong></p>
<ul>
    @foreach($game->gameLanguages as $gameLanguage)
        @if($gameLanguage->language)
            <li>{{ $gameLanguage->language->name ?? 'If not displaying, something is wrong!' }} (id = {{ $gameLanguage->language }})</li>
        @else
            <li>Language Not Found</li>
        @endif
    @endforeach
</ul>

<p><strong>Players:</strong></p>
<ul>
    @foreach($game->gamePlayers as $gamePlayer)
        @if($gamePlayer->player)
            <li>{{ $gamePlayer->player->name ?? 'If not displaying, something is wrong!' }} (id = {{ $gamePlayer->player }})</li>
        @else
            <li>Player Not Found</li>
        @endif
    @endforeach
</ul>

@endsection