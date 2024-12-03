@extends('layouts.app')

@section('title', "My Products")

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">My Products</h1>

    <a href="{{ route('games.create') }}" class="btn btn-primary mb-3">New Game</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="product-list">
        @if ($games->isEmpty())
            <p>No products found.</p>
        @else
                
            @foreach($games as $game)
                @include('partials.game-card-seller-listing', ['game' => $game])
            @endforeach

            <!-- Pagination Links -->
            <div class="pagination-links">
                {{ $games->links() }}
            </div>
        @endif
    </div>
</div>
@endsection