@extends('layouts.app')

@section('title', 'Home')

@section('content')

<script src="{{ asset('js/home/home.js') }}" defer></script>
<script src="{{ asset('js/cart/add-to-cart.js') }}" defer></script>

<section id="home">
    <div id="top-sellers-container">
        @include('partials.top-sellers-chunk', ['topSellersChunk' => $topSellersChunks[0], 'chunkIndex' => 0])
    </div>

    <div class="pagination-controls" data-total-chunks="{{ count($topSellersChunks) }}">
        @foreach ($topSellersChunks as $chunkIndex => $topSellersChunk)
            <button class="pagination-btn" onclick="loadChunk({{ $chunkIndex }})">{{ $chunkIndex + 1 }}</button>
        @endforeach
    </div>

    <!-- Smaller cards for similar games -->
    <div class="similar-games-section">
        <div class="similar-game-cards">
            @foreach ($similarGames as $similarGame)
                @include('partials.small-game-card-home', ['game' => $similarGame])
            @endforeach
        </div>
    </div>
</section>

@endsection