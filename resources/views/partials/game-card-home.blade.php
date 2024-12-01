<div class="home-game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-thumbnail">
        <img src="{{ asset('images/home-game-image.png') }}" class="card-img-top" alt="{{ $game->name }}">
        <!-- Game Price -->
        <p class="game-price-thumbnail">
            €{{ number_format($game->price, 2) }}
        </p>
    </div>
    <!-- Overlay for video and details -->
    <div class="overlay">
        <!-- Game Small Image -->
        <div class="top-media">
            <img src="{{ asset('images/default-game-image.jpg') }}" alt="{{ $game->name }}">
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
            <!-- Game Platforms -->
            <div class="game-platforms">
                @foreach($game->platforms as $platform)
                    <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" class="img-fluid">
                @endforeach
            </div>
            <!-- Game Price -->
            <p class="game-price">
                €{{ number_format($game->price, 2) }}
            </p>
        </div>
    </div>
    <!-- Add to Cart Button -->
    <div class="add-to-cart">
        @if (!auth_user() || auth_user()->buyer)
            <button id="add-to-cart-{{ $game->id }}" data-id="{{ $game->id }}" class="btn-add-to-cart btn btn-primary">
                Add to Cart
            </button>
        @endif
    </div>
</div>