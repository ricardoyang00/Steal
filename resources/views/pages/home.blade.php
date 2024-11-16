@extends('layouts.app')

@section('title', 'Home')

@section('content')
<form action="{{ url('/home') }}" method="GET" class="mb-4">
    <div class="btn-group" role="group" aria-label="Game Filters">
        <button type="submit" name="filter" value="all" class="btn btn-outline-primary {{ request('filter') == 'all' ? 'active' : '' }}">
            All Items
        </button>
        <button type="submit" name="filter" value="new-releases" class="btn btn-outline-primary {{ request('filter') == 'new-releases' ? 'active' : '' }}">
            New
        </button>
        <button type="submit" name="filter" value="top-selling" class="btn btn-outline-primary {{ request('filter') == 'top-selling' ? 'active' : '' }}">
            Top Selling
        </button>
        <button type="submit" name="filter" value="top-rated" class="btn btn-outline-primary {{ request('filter') == 'top-rated' ? 'active' : '' }}">
            Top Rated
        </button>
    </div>
</form>

<div class="container py-5">
    <h1 class="text-center mb-4">Available Games</h1>
    <div class="row g-4">
        <div class="col-12">
            @foreach($games as $game)
                @include('partials.game-card', ['game' => $game])
            @endforeach
        </div>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $games->links() }}
    </div>
</div>
@endsection