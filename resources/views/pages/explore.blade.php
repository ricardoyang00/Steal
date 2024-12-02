@extends('layouts.app')

@section('title', 'Explore')

@section('content')

@if (!auth_user() || auth_user()->buyer)
    <script src="{{ asset('js/cart/add-to-cart.js') }}" defer></script>
    <script src="{{ asset('js/explore/game_card.js') }}" defer></script>
    <script src="{{ asset('js/explore/filter.js') }}" defer></script>
@endif

<div class="explore-page">
    <div class="filter-table">
        <h1>FILTERS</h1>
        <form id="filter-form" action="{{ url('/explore') }}" method="GET" class="filter-form">
            <!-- Persist query -->
            @if(request('query'))
                <input type="hidden" name="query" value="{{ request('query') }}">
            @endif

            <!-- Persist sort -->
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            
            <button type="button" id="clear-filters" class="btn btn-secondary">Clear Filters</button>
            
            <!-- Filters -->
            <div class="form-group">
                <label for="category">Category</label>
                @foreach($categories as $category)
                    <div class="form-check">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input" id="category{{ $category->id }}" {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="platform">Platform</label>
                @foreach($platforms as $platform)
                    <div class="form-check">
                        <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" class="form-check-input" id="platform{{ $platform->id }}" {{ in_array($platform->id, request('platforms', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="platform{{ $platform->id }}">{{ $platform->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="language">Language</label>
                @foreach($languages as $language)
                    <div class="form-check">
                        <input type="checkbox" name="languages[]" value="{{ $language->id }}" class="form-check-input" id="language{{ $language->id }}" {{ in_array($language->id, request('languages', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="language{{ $language->id }}">{{ $language->name }}</label>
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="player">Player</label>
                @foreach($players as $player)
                    <div class="form-check">
                        <input type="checkbox" name="players[]" value="{{ $player->id }}" class="form-check-input" id="player{{ $player->id }}" {{ in_array($player->id, request('players', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="player{{ $player->id }}">{{ $player->name }}</label>
                    </div>
                @endforeach
            </div>
        </form>
    </div>

    <div class="game-content">
        <nav class="explore-navbar">
            <div class="search-text">
                @if(request('query'))
                    <p class="text-center">Showing results for "<strong>{{ request('query') }}</strong>":</p>
                @endif
            </div>
            <form action="{{ url('/explore') }}" method="GET" class="sorting-form">
                <!-- Persist query -->
                @if(request('query'))
                    <input type="hidden" name="query" value="{{ request('query') }}">
                @endif

                <!-- Persist filters -->
                @foreach(request('categories', []) as $category)
                    <input type="hidden" name="categories[]" value="{{ $category }}">
                @endforeach
                @foreach(request('platforms', []) as $platform)
                    <input type="hidden" name="platforms[]" value="{{ $platform }}">
                @endforeach
                @foreach(request('languages', []) as $language)
                    <input type="hidden" name="languages[]" value="{{ $language }}">
                @endforeach
                @foreach(request('players', []) as $player)
                    <input type="hidden" name="players[]" value="{{ $player }}">
                @endforeach

                <!-- Sort -->
                <div class="links" role="group" aria-label="Game Sorting">
                    <button type="submit" name="sort" value="all" class="btn btn-link {{ request('sort') == 'all' || (!request('sort') && !request('query')) ? 'active' : '' }}">
                        All Items
                    </button>
                    <button type="submit" name="sort" value="new-releases" class="btn btn-link {{ request('sort') == 'new-releases' ? 'active' : '' }}">
                        New
                    </button>
                    <button type="submit" name="sort" value="top-sellers" class="btn btn-link {{ request('sort') == 'top-sellers' ? 'active' : '' }}">
                        Top Sellers
                    </button>
                    <button type="submit" name="sort" value="top-rated" class="btn btn-link {{ request('sort') == 'top-rated' ? 'active' : '' }}">
                        Top Rated
                    </button>
                </div>
            </form>
        </nav>

        <div class="game-cards">
            @if(request('query'))
                <p class="text-center">
                    {{ $games->total() }} {{ $games->total() == 1 ? 'result matches' : 'results match' }} your search.
                </p>
            @endif
            @if($games->isEmpty())
                <p class="text-center">No games found.</p>
            @endif
            @foreach($games as $game)
                @include('partials.game-card-explore', ['game' => $game])
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="pagination-links">
            {{ $games->appends(request()->except('page'))->links() }}
        </div>

    </div>
</div>

@endsection