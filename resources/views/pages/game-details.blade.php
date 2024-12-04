@extends('layouts.app')

@section('title', $game->name)

@section('content')

@if (!auth_user() || auth_user()->buyer)
<script src="{{ asset('js/wishlist/add-to-wishlist.js') }}" defer></script>
<script src="{{ asset('js/cart/add-to-cart.js') }}" defer ></script>
<script src="{{ asset('js/game_details/game_details.js') }}" defer></script>
@endif

<div class="game-details-page">
    <div class="game-image">
        <img src="{{ asset('images/' . $game->getThumbnailLargePath()) }}" class="img-fluid" alt="{{ $game->name }}">
    </div>
    <div class="game-details">
        <h1>{{ $game->name }}</h1>
        <p><strong>Description:</strong> {{ $game->description }}</p>
        <p><strong>Owner:</strong> {{ $game->seller->name }}</p>
        <p><strong>Minimum Age:</strong>
            <a href="{{ url('age/' . $game->age->id) }}">
                <img src="{{ asset('images/' . $game->age->image_path) }}" alt={{ $game->age->name }} style="width: 50px; height: auto;">
            </a>
        </p>
        <p><strong>Price:</strong> ${{ $game->price }}</p>
        <p><strong>Release Date:</strong> {{ $game->getReleaseDate() }}</p>
        <p><strong>Rating:</strong> {{ $game->overall_rating }}%</p>
        @if (auth_user() && auth_user()->buyer)
            <button class="add-to-wishlist btn-add-to-wishlist" data-id="{{ $game->id }}">
                <i class="far fa-heart"></i>
            </button>
        @elseif (!auth_user())
            <button onclick="window.location.href = '/login';" class="add-to-wishlist">
                <i class="far fa-heart"></i>
            </button>
        @endif
        @if (!auth_user() || auth_user()->buyer)
            <button id="add-to-cart-{{ $game['id'] }}" data-id="{{ $game['id'] }}" class="btn-add-to-cart btn btn-primary">
                Add to Cart
            </button>
        @endif
    </div>
    
    <p><strong>Available Platforms:</strong></p>
    <ul>
        @foreach($game->platforms as $platform)
        <li>{{ $platform->name }}</li>
        @endforeach
    </ul>
    
    <p><strong>Categories:</strong></p>
    <ul>
        @foreach($game->categories as $category)
        <li>{{ $category->name }}</li>
        @endforeach
    </ul>
    
    <p><strong>Languages:</strong></p>
    <ul>
        @foreach($game->languages as $language)
        <li>{{ $language->name }}</li>
        @endforeach
    </ul>
    
    <p><strong>Players:</strong></p>
    <ul>
        @foreach($game->players as $player)
        <li>{{ $player->name }}</li>
        @endforeach
    </ul>
    
    <h2>Reviews</h2>
    <div class="game-reviews" data-id="{{ $game->id }}">
        <div class="review-controls">
            @if (auth_user() && auth_user()->buyer && auth()->user()->hasDeliveredPurchase($game->id) && !$game->hasReviewedGame(auth()->user()))
                <button class="btn-review-form-toggle">Add Review</button>
                @if ($errors->any())
                    <div class="error error-reviews">
                        {{ $errors->first() }}
                    </div>
                @endif
            @elseif (auth_user() && auth_user()->buyer && !$game->hasReviewedGame(auth()->user()))
                <p class="review-form-message">
                    You must have purchased this game to leave a review.
                </p>
            @elseif (auth_user() && auth_user()->buyer && $game->hasReviewedGame(auth()->user()))
                <p class="review-form-message">
                    <button class="btn-review-form-toggle">Edit Review</button>
                    @if ($errors->any())
                        <div class="error error-reviews">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </p>
            @elseif (!auth_user())
                <p class="review-form-message">
                    You must be logged in to leave a review.
                </p>
            @endif
        </div>
        <div class="reviews">
            @if (!$game->hasReviews())
                <p class="no-reviews-message">
                    There are no reviews for this game yet.
                </p>
            @endif
            <div class="add-review-container" style="display: none;">
                <div class="btn-close-div">
                    @if (auth_user() && auth_user()->buyer && $game->hasReviewedGame(auth()->user()))
                        <h3>Edit Review</h3>
                        <form class="edit-review-form" action="{{ url('reviews/edit') }}" method="POST">
                    @else
                        <h3>Add Review</h3>
                        <form class="add-review-form" action="{{ url('reviews/add') }}" method="POST">
                    @endif
                    <button class="btn-close-review-form">x</button>
                </div>
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $game->id }}">
                    <div class="form-group">
                        <label for="review-title">Title</label>
                        <input type="text" class="form-control" id="review-title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="review-description">Description</label>
                        <textarea class="form-control" id="review-description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="review-rating">Rating</label>
                        <div class="form-check thumbs-up">
                            <input class="form-check-input" type="radio" name="positive" id="review-positive" value="true" required>
                            <label class="form-check-label" for="review-positive">
                                <i class="fas fa-thumbs-up" style="color: lightgreen;"></i> Positive
                            </label>
                        </div>
                        <div class="form-check thumbs-up">
                            <input class="form-check-input" type="radio" name="positive" id="review-negative" value="false" required>
                            <label class="form-check-label" for="review-negative">
                                <i class="fas fa-thumbs-down" style="color: red;"></i> Negative
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Review</button>
                </form>
            </div>
            <!-- Reviews will be loaded here by the JS -->
        </div>
    </div>
</div>


@endsection