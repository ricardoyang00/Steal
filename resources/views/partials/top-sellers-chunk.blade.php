<div class="top-sellers-section" id="top-sellers-{{ $chunkIndex }}">
    @foreach($topSellersChunk as $game)
        @include('partials.game-card-home', ['game' => $game])
    @endforeach
</div>

<!-- Smaller cards for similar games -->
{{--
@foreach ($topSellersChunk as $game)
    <div class="similar-games-section">
        <h3>Similar Games for {{ $game->name }}</h3>
        <div class="similar-game-cards">
            @foreach ($similarGames[$chunkIndex][$game->id] as $similarGame)
                @include('partials.small-game-card-home', ['game' => $similarGame])
            @endforeach
        </div>
    </div>
@endforeach
--}}