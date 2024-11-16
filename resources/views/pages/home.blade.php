@extends('layouts.app')

@section('title', 'Home')

@section('content')
<form action="{{ url('/home') }}" method="GET" class="mb-4">
    <select name="filter" class="form-select" onchange="this.form.submit()">
        <option value="" disabled selected>Select a Filter</option>
        <option value="all" {{ request('filter') == 'all' ? 'selected' : '' }}>All Items</option>
        <option value="new-releases" {{ request('filter') == 'new-releases' ? 'selected' : '' }}>New</option>
        <option value="top-selling" {{ request('filter') == 'top-selling' ? 'selected' : '' }}>Top Selling</option>
        <option value="top-rated" {{ request('filter') == 'top-rated' ? 'selected' : '' }}>Top Rated</option>
    </select>
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