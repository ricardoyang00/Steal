<script src="{{ asset('js/explore/tag-filter.js') }}" defer></script>
<script src="{{ asset('js/admin/block-modal.js') }}" defer></script>
@include('partials.admin.block-modal')

<div class="game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-thumbnail">
        <a href="{{ route('game.details', ['id' => $game->id]) }}">
            <img src="{{ asset($game->getThumbnailLargePath()) }}" class="card-img-top" alt="{{ $game->name }}">
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
                <a href="#" class="tag" data-category-id="{{ $category->id }}" onclick="filterByCategory({{ $category->id }})">{{ $category->name }}</a>
            @endforeach
            @foreach($game->players as $player)
                <a href="#" class="tag" data-player-id="{{ $player->id }}" onclick="filterByPlayer({{ $player->id }})">{{ $player->name }}</a>
            @endforeach
        </div>
        <!-- Game Platforms and Release Date -->
        <div class="game-platform-release-date">
            @foreach($game->platforms as $platform)
                <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" class="img-fluid" style="width: 20px; height: 30px;">
            @endforeach
            <a>{{ $game->getReleaseDate() }}</a>
        </div>
        <!-- Rating -->
        <div class="game-rating">
            <div class="rating-labels">
                @if ($game->hasReviews())
                    <span class="positive-label">{{ $game->overall_rating }}% <i class="fa fa-thumbs-up"></i></span>
                    <span class="negative-label">{{ 100 - $game->overall_rating }}% <i class="fa fa-thumbs-down"></i></span>
                @else
                    <span class="no-reviews-label">0% <i class="fa fa-thumbs-up"></i></span>
                    <span class="no-reviews-label">0% <i class="fa fa-thumbs-down"></i></span>
                @endif
            </div>
            <div class="rating-bar">
                @if ($game->hasReviews())
                    <div class="rating-positive" style="width: {{ $game->overall_rating }}%;"></div>
                    <div class="rating-negative" style="width: {{ 100 - $game->overall_rating }}%;"></div>
                @else
                    <div class="rating-no-reviews" style="width: 100%;"></div>
                @endif
            </div>
        </div>
    </div>
    <!-- Wishlist Button -->
    @if (auth_user() && auth_user()->buyer)
        <button class="add-to-wishlist btn-add-to-wishlist" data-id="{{ $game->id }}">
            <i class="far fa-heart"></i>
        </button>
    @elseif (!auth_user())
        <button onclick="window.location.href = '/login';" class="add-to-wishlist">
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
        @elseif (is_admin())
            @if ($game->is_active)
                <form action="{{ route('admin.games.block', $game->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="button" class="btn btn-primary" id="block-game" onclick="showBlockModal({{ $game->id }})">Block</button>
                </form>
            @endif
        @endif
    </div>
</div>