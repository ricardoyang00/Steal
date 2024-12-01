<div class="game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
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
            <a href="{{ route('game.details', ['id' => $game->id]) }}">
                {{ $game->name }}
            </a>
        </h5>
        <!-- Game Tags (Categories and Players) -->
        <div class="game-tags">
            @foreach($game->categories as $category)
                <a href="javascript:void(0);" class="tag">{{ $category->name }}</a>
            @endforeach
            @foreach($game->players as $player)
                <a href="javascript:void(0);" class="tag">{{ $player->name }}</a>
            @endforeach
        </div>
        <!-- Game Platforms and Release Date -->
        <div class="game-platform-release-date">
            @foreach($game->platforms as $platform)
                <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" class="img-fluid" style="width: 20px; height: 30px;">
            @endforeach
            <a>{{ \Carbon\Carbon::parse($game->release_date)->format('d M, Y') }}</a>
        </div>
        <!-- Rating -->
        <div class="game-rating">
            <div class="rating-labels">
                <span class="positive-label">{{ $game->overall_rating }}% <i class="fa fa-thumbs-up"></i></span>
                <span class="negative-label">{{ 100 - $game->overall_rating }}% <i class="fa fa-thumbs-down"></i></span>
            </div>
            <div class="rating-bar">
                <div class="rating-positive" style="width: {{ $game->overall_rating }}%;"></div>
                <div class="rating-negative" style="width: {{ 100 - $game->overall_rating }}%;"></div>
            </div>
        </div>
    </div>
    <!-- Wishlist Button -->
    @if (!auth_user() || auth_user()->buyer)
        <button class="add-to-wishlist btn-add-to-wishlist" data-id="{{ $game->id }}">
            <i class="far fa-heart"></i>
        </button>
    @endif
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