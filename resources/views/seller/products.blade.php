@extends('layouts.app')

@section('title', "My Products")

@section('content')
<div class="container mt-5">
    <h1 class="text-primary">My Products</h1>
    
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