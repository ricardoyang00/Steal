@extends('layouts.app')

@section('title', 'Explore')

@section('content')

@if (!auth_user() || auth_user()->buyer)
    <script src="{{ asset('js/cart/add-to-cart.js') }}" defer></script>
    <script src="{{ asset('js/wishlist/add-to-wishlist.js') }}" defer></script>
@endif

<script src="{{ asset('js/explore/game_card.js') }}" defer></script>    
<script src="{{ asset('js/explore/filter.js') }}" defer></script>

<div class="explore-page">
    <div class="filter-table">
        <div class="filter-header">
            <h1>FILTERS</h1>
            <button type="button" id="clear-filters" class="btn btn-secondary">
                <i class="fa-solid fa-filter-circle-xmark"></i>
            </button>
        </div>

        <div class="active-filters">
            <!-- AJAX to dinamically show active filters -->
        </div>

        <form id="filter-form" action="{{ url('/explore') }}" method="GET" class="filter-form">
            <!-- Persist query -->
            @if(request('query'))
                <input type="hidden" name="query" value="{{ request('query') }}">
            @endif

            <!-- Persist sort -->
            @if(request('sort'))
                <input type="hidden" name="sort" value="{{ request('sort') }}">
            @endif
            <!-- Filters -->
            <div class="form-group">
                <label class="collapsible">Category</label>
                <div class="content category">
                    @foreach($categories as $category)
                        <div class="form-check-container {{ $loop->index >= 5 ? 'hidden-category' : '' }}">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-check-input" id="category{{ $category->id }}" {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                    @if(count($categories) > 5)
                        <button type="button" id="see-more-btn-category" class="btn btn-link">See More</button>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="collapsible">Platform</label>
                <div class="content platform">
                    @foreach($platforms as $platform)
                        <div class="form-check-container {{ $loop->index >= 5 ? 'hidden-category' : '' }}">
                            <input type="checkbox" name="platforms[]" value="{{ $platform->id }}" class="form-check-input" id="platform{{ $platform->id }}" {{ in_array($platform->id, request('platforms', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="platform{{ $platform->id }}">{{ $platform->name }}</label>
                        </div>
                    @endforeach
                    @if(count($platforms) > 5)
                        <button type="button" id="see-more-btn-platform" class="btn btn-link">See More</button>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="collapsible">Language</label>
                <div class="content language">
                    @foreach($languages as $language)
                        <div class="form-check-container {{ $loop->index >= 5 ? 'hidden-category' : '' }}">
                            <input type="checkbox" name="languages[]" value="{{ $language->id }}" class="form-check-input" id="language{{ $language->id }}" {{ in_array($language->id, request('languages', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="language{{ $language->id }}">{{ $language->name }}</label>
                        </div>
                    @endforeach
                    @if(count($languages) > 5)
                        <button type="button" id="see-more-btn-language" class="btn btn-link">See More</button>
                    @endif
                </div>
            </div>
            
            <div class="form-group">
                <label class="collapsible">Player</label>
                <div class="content">
                    @foreach($players as $player)
                        <div class="form-check-container">
                            <input type="checkbox" name="players[]" value="{{ $player->id }}" class="form-check-input" id="player{{ $player->id }}" {{ in_array($player->id, request('players', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="player{{ $player->id }}">{{ $player->name }}</label>
                        </div>
                    @endforeach
                </div>
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
                    <button type="submit" name="sort" value="all" class="btn btn-link {{ request('sort') == 'all' || !request('sort') ? 'active' : '' }}">
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

        @include('partials.explore.game-cards')

    </div>
</div>

@endsection