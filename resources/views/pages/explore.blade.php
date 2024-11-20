@extends('layouts.app')

@section('title', 'Explore')

@section('content')

@if (!auth_user() || auth_user()->buyer)
    <script src="{{ asset('js/cart/add-to-cart.js') }}" defer></script>
    <script src="{{ asset('js/explore/game_card.js') }}" defer></script>
@endif

<div class="explore-page">
    <div class="filter-table">
        <h1>FILTERS</h1>
        <p><strong>IN CONTRUCTION...</strong></p>
        <p><strong>IN CONTRUCTION...</strong></p>
        <p><strong>IN CONTRUCTION...</strong></p>
        <p><strong>IN CONTRUCTION...</strong></p>
        <p><strong>IN CONTRUCTION...</strong></p>
    </div>
    <div class="game-content">
        <nav class="explore-navbar">
            <form action="{{ url('/explore') }}" method="GET">
                <div class="links" role="group" aria-label="Game Sorting">
                    <button type="submit" name="sort" value="all" class="btn btn-link {{ request('sort') == 'all' ? 'active' : '' }}">
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
            @foreach($games as $game)
                @include('partials.game-card-explore', ['game' => $game])
            @endforeach
        </div>

        <!--
        @if(isset($query) && $query)
            <p class="text-center">Showing results for "<strong>{{ $query }}</strong>":</p>
        @endif
        -->

        <!-- Pagination Links -->
        <div class="pagination-links">
            {{ $games->appends(request()->except('page'))->links() }}
        </div>

    </div>
</div>

@endsection