<div class="home-small-game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-small-thumbnail">
        <a href="{{ route('game.details', ['id' => $game->id]) }}">
            <img src="{{ asset('images/default-game-image.jpg') }}" class="card-img-top" alt="{{ $game->name }}">
        </a>
    </div>
    <!-- Game Details -->
    <div class="game-details">
        <!-- Game Title -->
        <h5 class="game-title">
            <a href="{{ route('game.details', ['id' => $game->id]) }}">
                {{ $game->name }}
            </a>
        </h5>
        <p class="game-description">
            {{ $game->description }}
        </p>
    </div>
    <!-- Game Price -->
    <p class="game-price">
        €{{ number_format($game->price, 2) }}
    </p>
</div>