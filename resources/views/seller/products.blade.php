@extends('layouts.app')

@section('title', "My Products")

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">My Products</h1>

    <div class = "new-game-btn">
        <a href="{{ route('games.create') }}">New Game</a>
    </div>

    <div class="seller-product-list">
        <div class="game-cards">
            @if ($games->isEmpty())
                <p>No products found.</p>
            @else
                    
                @foreach($games as $game)
                    @include('seller.game-card-seller-listing', ['game' => $game])
                @endforeach

                <!-- Pagination Links -->
                <div class="pagination-links">
                    {{ $games->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection