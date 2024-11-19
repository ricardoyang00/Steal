<div class="game-card">
    <!-- Game Thumbnail -->
    <div class="game-thumbnail">
        <a href="{{ route('game.details', ['id' => $game->id]) }}">
            <img src="{{ asset('images/default-game-image.jpg') }}" class="card-img-top" alt="{{ $game->name }}">
        </a>
    </div>
    <!-- Game Details -->
    <div class="game-details">
        <!-- Game Title -->
        <h5 class="game-title">
            <a href="{{ route('game.details', ['id' => $game->id]) }}" class="text-decoration-none text-dark">
                {{ $game->name }}
            </a>
        </h5>
        <!-- Game Platforms and Release Date -->
        <div class="game-platform-release-date">
            @foreach($game->platforms as $platform)
                <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" class="img-fluid" style="width: 20px; height: auto;">
            @endforeach
            <a>{{ \Carbon\Carbon::parse($game->release_date)->format('d M, Y') }}</a>
        </div>
        <!-- Rating -->
        <p class="game-rating">
            <strong>Rating:</strong> {{ $game->overall_rating }}%
        </p>
    </div>
    <!-- Game Price and Add to Cart -->
    <div class="game-price-add-cart">
        <p class="game-price">
            €{{ number_format($game->price, 2) }}
        </p>
        @if (!auth_user() || auth_user()->buyer)
            <button id="add-to-cart-{{ $game->id }}" data-id="{{ $game->id }}" class="btn-add-to-cart btn btn-primary">
                Add to Cart
            </button>
        @endif
    </div>
</div>