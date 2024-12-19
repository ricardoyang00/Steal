@extends('layouts.app')

@section('title', 'Home')

@section('content')

<script src="{{ asset('js/home/home.js') }}" defer></script>

<section id="home">
    <h2 class="section-title">Top Sellers</h2>
    <div id="top-sellers-container">
        @include('partials.home.top-sellers-chunk', ['topSellersChunk' => $topSellersChunks[0], 'chunkIndex' => 0])
    </div>

    <div class="pagination-controls" data-total-chunks="{{ count($topSellersChunks) }}">
        @foreach ($topSellersChunks as $chunkIndex => $topSellersChunk)
            <button class="pagination-btn" onclick="loadChunk({{ $chunkIndex }})">{{ $chunkIndex + 1 }}</button>
        @endforeach
    </div>

    <div class="similar-games-section">
        <h2 class="section-title" id="similar-games">Similar Games</h2>
        <div class="similar-game-cards">
            @foreach ($similarGames as $similarGame)
                @include('partials.home.small-game-card-home', ['game' => $similarGame])
            @endforeach
        </div>
    </div>

    @if ($recommendedGames->isNotEmpty())
    <div class="recommended-games-section">
        <h2 class="section-title" id="interests">You might also be interested in</h2>
        <div class="recommended-game-cards">
            @foreach ($recommendedGames as $recommendedGame)
                @include('partials.home.recommended-games', ['game' => $recommendedGame])
            @endforeach
        </div>
    </div>
@endif
</section>

@endsection