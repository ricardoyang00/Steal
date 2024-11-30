@extends('layouts.app')

@section('title', 'Home')

@section('content')

<script src="{{ asset('js/home/home.js') }}" defer></script>

<section id="home">
    <!-- Carousel for Top Sellers -->
    <div class="top-sellers-carousel">
        <button class="carousel-btn left" onclick="moveCarousel('top-sellers', -1)">&#8249;</button>
        <div class="carousel-track" id="top-sellers">
            @foreach($topSellers as $game)
                @include('partials.game-card-home', ['game' => $game])
            @endforeach
        </div>
        <button class="carousel-btn right" onclick="moveCarousel('top-sellers', 1)">&#8250;</button>
    </div>

    <!-- Smaller cards for similar games -->
    {{-- 
        @foreach ($topSellers as $game)
            <div class="similar-games-section">
                <h3>Similar Games for {{ $game->name }}</h3>
                <div class="similar-game-cards">
                    @foreach ($similarGames[$game->id] as $similarGame)
                        @include('partials.small-game-card-home', ['game' => $similarGame])
                    @endforeach
                </div>
            </div>
        @endforeach 
    --}}
</section>

@endsection