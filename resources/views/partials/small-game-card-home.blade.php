<div class="home-small-game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-small-thumbnail">
        <a href="{{ route('game.details', ['id' => $game->id]) }}">
            <img src="{{ asset('images/' . $game->getThumbnailLargePath()) }}" class="card-img-top" alt="{{ $game->name }}">
        </a>
        <!-- Game Price -->
        <p class="game-price">
            €{{ number_format($game->price, 2) }}
        </p>
    </div>
</div>