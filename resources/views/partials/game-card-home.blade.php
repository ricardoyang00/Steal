<div class="home-game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-thumbnail">
        <!-- <a href="{{ route('game.details', ['id' => $game->id]) }}"> -->
            <img src="{{ asset('images/home-game-image.png') }}" class="card-img-top" alt="{{ $game->name }}">
        <!-- </a> -->
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
            <!-- Game Price and Platforms -->
            <div class="game-price-platforms">
                <p class="game-price">
                    €{{ number_format($game->price, 2) }}
                </p>
                @foreach($game->platforms as $platform)
                    <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" class="img-fluid">
                @endforeach
            </div>
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