<div class="top-sellers-section" id="top-sellers-{{ $chunkIndex }}">
    @foreach($topSellersChunk as $game)
        <div class="home-game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
            <!-- Game Thumbnail -->
            <div class="game-thumbnail">
                <!-- Game Age -->
                <a href="{{ url('age/' . $game->age->id) }}">
                    <img src="{{ asset('images/' . $game->age->image_path) }}" alt={{ $game->age->name }} class="pegi-age">
                </a>
                <!-- Game Big Image -->
                <img src="{{ asset('images/home-game-image.jpg') }}" class="card-img-top" alt="{{ $game->name }}" width="270px" height="400px">
                <!-- Game Price -->
                <p class="game-price-thumbnail">
                    €{{ number_format($game->price, 2) }}
                </p>
            </div>
            <!-- Overlay -->
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
                    <!-- Game Tags -->
                    <div class="game-categories">
                        @foreach($game->categories as $category)
                            <p class="category-tag">{{ $category->name }}</p>
                        @endforeach
                    </div>
                    <!-- Game Platforms -->
                    <div class="game-platforms">
                        @foreach($game->platforms as $platform)
                            <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" class="img-fluid">
                        @endforeach
                    </div>
                    <!-- Add to Cart Button -->
                    @if (!auth_user() || auth_user()->buyer)
                        <button id="add-to-cart-{{ $game['id'] }}" data-id="{{ $game['id'] }}" class="btn-add-to-cart btn btn-primary">
                            Add to Cart
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>