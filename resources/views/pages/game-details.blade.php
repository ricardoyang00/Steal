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
            <p><strong>Owner:</strong> {{ $game->seller->name ?? 'Unknown Seller' }}</p>
            <p><strong>Minimum Age:</strong> {{ $game->minimum_age }}</p>
            <p><strong>Price:</strong> ${{ $game->price }}</p>
            <p><strong>Rating:</strong> {{ $game->overall_rating }}%</p>

            <p><strong>Available Platforms:</strong></p>
            <ul>
                @foreach($game->gamePlatforms as $gamePlatform)
                    @if($gamePlatform->platform)
                        <li>{{ $gamePlatform->platform }}</li>
                    @else
                        <li>Platform Not Found</li>
                    @endif
                @endforeach
            </ul>

            <a href="#" class="btn btn-primary">Buy Now</a>
        </div>
    </div>
</div>
@endsection