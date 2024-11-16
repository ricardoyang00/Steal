@extends('layouts.app')

@section('title', 'Explore')

@section('content')
<form action="{{ url('/explore') }}" method="GET" class="mb-4">
    <div class="btn-group" role="group" aria-label="Game Sorting">
        <button type="submit" name="sort" value="all" class="btn btn-outline-primary {{ request('sort') == 'all' ? 'active' : '' }}">
            All Items
        </button>
        <button type="submit" name="sort" value="new-releases" class="btn btn-outline-primary {{ request('sort') == 'new-releases' ? 'active' : '' }}">
            New
        </button>
        <button type="submit" name="sort" value="top-selling" class="btn btn-outline-primary {{ request('sort') == 'top-selling' ? 'active' : '' }}">
            Top Selling
        </button>
        <button type="submit" name="sort" value="top-rated" class="btn btn-outline-primary {{ request('sort') == 'top-rated' ? 'active' : '' }}">
            Top Rated
        </button>
    </div>
</form>

<div class="container py-5">
    <h1 class="text-center mb-4">Explore Games</h1>
    @if(isset($query) && $query)
        <p class="text-center">Showing results for "<strong>{{ $query }}</strong>":</p>
    @endif
    <div class="row g-4">
        <div class="col-12">
            @foreach($games as $game)
                @include('partials.game-card-explore', ['game' => $game])
            @endforeach
        </div>
    </div>
</div>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-4">
    {{ $games->appends(request()->except('page'))->links() }}
</div>
@endsection