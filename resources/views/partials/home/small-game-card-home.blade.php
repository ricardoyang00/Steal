<div class="home-small-game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-small-thumbnail">
        <a href="{{ route('game.details', ['id' => $game->id]) }}">
            <img src="{{ asset($game->getThumbnailLargePath()) }}" class="card-img-top" alt="{{ $game->name }}">
        </a>
        <!-- Game Price -->
        <p class="game-price">
            €{{ number_format($game->price, 2) }}
        </p>
        <!-- Game Title -->
        <a class="game-title" href="{{ route('game.details', ['id' => $game->id]) }}">
            {{ $game->name }}
        </a>
    </div>
</div>