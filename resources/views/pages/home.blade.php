@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-4">Available Games</h1>

    @if($games->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            No games available at the moment.
        </div>
    @else
        <div class="row g-4">
            <div class="col-12">
                @foreach($games as $game)
                    <div class="card">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <img src="{{ asset('images/default-game-image.jpg') }}" class="img-fluid rounded-start" alt="{{ $game->name }}" style="height: 200px; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title text-truncate" title="{{ $game->name }}">{{ $game->name }}</h5>
                                        <p class="card-text"><strong>Rating:</strong> {{ $game->overall_rating }}%</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="d-flex justify-content-between mt-auto">
                                    <p class="card-text"><strong>Price:</strong> ${{ number_format($game->price, 2) }}</p>
                                    <a href="#" class="btn btn-primary">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection