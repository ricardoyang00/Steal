<div class="game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-thumbnail">
        <a href="{{ route('game.details', ['id' => $game->id]) }}">
            <img src="{{ asset($game->getThumbnailLargePath()) }}" class="card-img-top" alt="{{ $game->name }}"  style="width: 400px; height: auto;">
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

        <!-- Game Tags (Categories, Platforms, Languages, and Players) -->
        <div class="game-tags">
            @foreach($game->categories as $category)
                <a href="javascript:void(0);" class="tag">{{ $category->name }}</a>
            @endforeach

            @foreach($game->platforms as $platform)
            <a href="javascript:void(0);" class="tag">{{ $platform->name }}</a>
            @endforeach

            @foreach($game->languages as $language)
                <a href="javascript:void(0);" class="tag">{{ $language->name }}</a>
            @endforeach

            @foreach($game->players as $player)
                <a href="javascript:void(0);" class="tag">{{ $player->name }}</a>
            @endforeach
        </div>
        
        <div class="game-release-date">
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
        
        <!-- Game Price -->
        <div class="game-price">
            <p>€{{ number_format($game->price, 2) }}</p>
        </div>
    </div>

    <!-- Game Buttons -->
    <div class="buttons">

        <!-- Edit Game Button -->
        <div class="game-edit-button">
            <a href="{{ route('games.edit', ['id' => $game->id]) }}" class="btn-edit-game btn btn-primary">
                <i class="fa-solid fa-pen"></i> Edit
            </a>
        </div>

        <!-- Add Stock Button -->
        <div class="game-stock-button">
            <a href="{{ route('games.cdks', ['id' => $game->id]) }}" class="btn-edit-game btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add Stock
            </a>
        </div>

        <!-- Purchase History Button -->
        <div class="game-history-button">
            <a href="{{ route('games.history', ['id' => $game->id]) }}" class="btn-edit-game btn btn-primary">
                <i class="fa-solid fa-chart-line"></i> Purchase History
            </a>
        </div>
    </div>
</div>