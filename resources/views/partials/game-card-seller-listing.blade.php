<div class="game-card" data-url="{{ route('game.details', ['id' => $game->id]) }}">
    <!-- Game Thumbnail -->
    <div class="game-thumbnail">
        <a href="{{ route('game.details', ['id' => $game->id]) }}">
            <img src="{{ asset('images/' . $game->getThumbnailLargePath()) }}" class="card-img-top" alt="{{ $game->name }}"  style="width: 400px; height: auto;">
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

        <!-- NOTE: USED THE SAME CODE FROM GAME-CARD-EXPLORE.BLADE.PHP, BUT MORE DETAILED -->
        <div class="game-categories">
            @foreach($game->categories as $category)
                <a href="javascript:void(0);" class="tag">{{ $category->name }}</a>
            @endforeach
        </div>
        <div class="game-platforms">
            @foreach($game->platforms as $platform)
            <a href="javascript:void(0);" class="tag">{{ $platform->name }}</a>
            @endforeach
        </div>
        <div class="game-languages">
            @foreach($game->languages as $language)
                <a href="javascript:void(0);" class="tag">{{ $language->name }}</a>
            @endforeach
        </div>
        <div class="game-players">
            @foreach($game->players as $player)
                <a href="javascript:void(0);" class="tag">{{ $player->name }}</a>
            @endforeach
        </div>
        <div class="game-release-date">
            <a>{{ \Carbon\Carbon::parse($game->release_date)->format('d M, Y') }}</a>
        </div>
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
        <div class="game-price">
            <p>€{{ number_format($game->price, 2) }}</p>
        </div>
    </div>
    <div class="game-edit-button">
        <a href="{{ route('games.edit', ['id' => $game->id]) }}" class="btn-edit-game btn btn-primary" style="color:white;">
            <i class="fa-solid fa-pen"></i> Edit
        </a>
    </div>
    <div class="game-stock-button">
        <a href="{{ route('games.edit', ['id' => $game->id]) }}" class="btn-edit-game btn btn-primary" style="color:white;">
            <i class="fa-solid fa-plus"></i></i> Add Stock
        </a>
    </div>
    <div class="game-history-button">
        <a href="{{ route('games.edit', ['id' => $game->id]) }}" class="btn-edit-game btn btn-primary" style="color:white;">
            <i class="fa-solid fa-chart-line"></i> Purchase History
        </a>
    </div>
    
</div>