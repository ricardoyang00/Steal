@extends('layouts.app')

@section('title', $game->name)

@section('content')

@if (!auth_user() || auth_user()->buyer)
    <script src="{{ asset('js/wishlist/add-to-wishlist.js') }}" defer></script>
    <script src="{{ asset('js/cart/add-to-cart.js') }}" defer ></script>
@endif

<script src="{{ asset('js/game_details/game_details.js') }}" defer></script>
<script src="{{ asset('js/admin/block-modal.js') }}" defer></script>
@include('partials.admin.block-modal')

<div class="game-details-page">
    <div class="game-details">
        <div class="game-title-div">
            <h1>{{ $game->name }}</h1>
            @if (auth_user() && auth_user()->buyer)
                <button class="add-to-wishlist btn-add-to-wishlist" data-id="{{ $game->id }}">
                    <p>Wishlist</p>
                    <i class="heart far fa-heart"></i>
                </button>
            @elseif (!auth_user())
                <button onclick="window.location.href = '/login';" class="add-to-wishlist">
                    <p>Wishlist</p>
                    <i class="heart far fa-heart"></i>
                </button>
            @endif
        </div>
        <!-- Game Box -->
        <div class="game-box">
            <!-- Game Images -->
            <div class="game-images-carousel">
                <div class="carousel-inner">
                    <div class="carousel-item">
                        <img src="{{ asset($game->getThumbnailLargePath()) }}" class="img-fluid" alt="{{ $game->name }}">
                    </div>
                    @if ($game->images && count($game->images) > 0)
                        @foreach($game->images as $image)
                            <div class="carousel-item">
                                <img src="{{ asset($image->path) }}" class="img-fluid" alt="{{ $game->name }}" style="width: 971px">
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item">
                            <img src="{{ asset($game->getThumbnailLargePath()) }}" class="img-fluid" alt="{{ $game->name }}">
                        </div>
                    @endif
                </div>
                @if (count($game->images) > 0)
                    <button class="carousel-control-prev" onclick="prevSlide()"><i class="fa fa-chevron-left"></i></button>
                    <button class="carousel-control-next" onclick="nextSlide()"><i class="fa fa-chevron-right"></i></button>
                @endif
            </div>
            <div class="game-info">
                <div class="game-image-container">
                    <!-- PEGI -->
                    <a href="{{ url('age/' . $game->age->id) }}" class="age-icon">
                        <img src="{{ asset($game->age->image_path) }}" alt={{ $game->age->name }} style="width: 50px; height: auto;">
                    </a>
                    <!-- Large Thumbnail -->
                    <div class="game-image">
                        <img src="{{ asset($game->getThumbnailLargePath()) }}" class="img-fluid" alt="{{ $game->name }}">
                    </div>
                </div>

                <!-- Game Info -->
                <div class="description-div">
                    <p>{{ $game->description }}</p>
                </div>

                <!-- Rating -->
                <div class="info-container">
                    <div class="info-label">Rating</div>
                    <div class="info-content">
                        <div class="game-rating">
                            <div class="rating-labels">
                                @if ($game->hasReviews())
                                    <span class="positive-label">{{ $game->overall_rating }}% <i class="fa fa-thumbs-up"></i></span>
                                    <span class="negative-label">{{ 100 - $game->overall_rating }}% <i class="fa fa-thumbs-down"></i></span>
                                @else
                                    <span class="no-reviews-label">0% <i class="fa fa-thumbs-up"></i></span>
                                    <span class="no-reviews-label">0% <i class="fa fa-thumbs-down"></i></span>
                                @endif
                            </div>
                            <div class="rating-bar">
                                @if ($game->hasReviews())
                                    <div class="rating-positive" style="width: {{ $game->overall_rating }}%;"></div>
                                    <div class="rating-negative" style="width: {{ 100 - $game->overall_rating }}%;"></div>
                                @else
                                    <div class="rating-no-reviews" style="width: 100%;"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Release Date -->
                <div class="info-container">
                    <div class="info-label">Release Date</div>
                    <div class="info-content">{{ $game->getReleaseDate() }}</div>
                </div>

                <!-- Platforms -->
                <div class="info-container">
                    <div class="info-label" id="platform-label">Platform</div>
                    <div class="info-content">
                        @foreach($game->platforms as $platform)
                            <img src="{{ asset('images/platform_logos/' . $platform->id . '.svg') }}" alt="{{ $platform->name }} logo" style="width: 20px; height: 30px;">
                        @endforeach
                    </div>
                </div>

                <!-- Owner -->
                <div class="info-container">
                    <div class="info-label">Owner</div>
                    <div class="info-content">{{ $game->seller->name }}</div>
                </div>

                <div class="tags-label">Tags</div>
                <div class="game-tags">
                    @foreach($game->categories as $category)
                        <span class="tag">{{ $category->name }}</span>
                    @endforeach
                    
                    @foreach($game->languages as $language)
                        <span class="tag">{{ $language->name }}</span>
                    @endforeach
                    
                    @foreach($game->players as $player)
                        <span class="tag">{{ $player->name }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="buy-product-div">
            @if (!auth_user() || auth_user()->buyer)
                <h1>Buy {{ $game->name }}</h1>
            @else
                <h1>{{ $game->name }}</h1>
            @endif

            <div class="game-price-add-cart-div">
                <p class="game-price"><strong>${{ $game->price }}</strong></p>
                @if (!auth_user() || auth_user()->buyer)
                    <button id="add-to-cart-{{ $game['id'] }}" data-id="{{ $game['id'] }}" class="btn-add-to-cart btn btn-primary">
                        Add to Cart
                    </button>
                @elseif (is_admin())
                    @if ($game->is_active)
                        <form action="{{ route('admin.games.block', $game->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="button" class="btn-add-to-cart btn btn-primary" id="block-game" onclick="showBlockModal({{ $game->id }})">Block</button>
                    @else
                        <form action="{{ route('admin.games.unblock', $game->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="button" class="btn-add-to-cart btn btn-primary" id="unblock-game">Unblock</button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <h2>Reviews</h2>
    <div class="game-reviews" data-id="{{ $game->id }}">
        <div class="reviews-bar">
            @if (auth_user() && auth_user()->buyer && auth()->user()->hasDeliveredPurchase($game->id) && !$game->hasReviewedGame(auth()->user()))
            <div class="review-buttons">
                <button class="btn-review-form-toggle">Add Review</button>
                <button class="btn-review-remove" style="display: none;">Remove Review</button>
            </div>
            @elseif (auth_user() && auth_user()->buyer && !$game->hasReviewedGame(auth()->user()))
                <p class="review-buttons">
                    You must have purchased this game to leave a review.
                </p>
            @elseif (auth_user() && auth_user()->buyer && $game->hasReviewedGame(auth()->user()))
                <div class="review-buttons">
                    <button class="btn-review-form-toggle">Edit Review</button>
                    <button class="btn-review-remove" data-id="{{ $review->id }}">Remove Review</button>
                </div>
            @elseif (!auth_user())
                <p class="review-buttons">
                    You must be logged in to leave a review.
                </p>
            @endif
            <!-- Rating -->
            <div class="game-rating">
                <div class="rating-labels">
                    <span class="positive-label">{{ $game->overall_rating }}% <i class="fa fa-thumbs-up"></i></span>
                    <span class="negative-label">{{ 100 - $game->overall_rating }}% <i class="fa fa-thumbs-down"></i></span>
                </div>
                <div class="rating-bar">
                    <div class="rating-positive" style="width: {{ $game->overall_rating }}%;"></div>
                    <div class="rating-negative" style="width: {{ 100 - $game->overall_rating }}%;"></div>
                </div>
            </div>
        </div>
        <div class="reviews">
            @if (!$game->hasReviews())
                <p class="no-reviews-message">
                    There are no reviews for this game yet.
                </p>
            @endif
            @if (auth_user() && auth_user()->buyer && $game->hasReviewedGame(auth()->user()))
                <div class="add-review-container edit" style="display: none;">
            @else
                <div class="add-review-container" style="display: none;">
            @endif
                <div class="btn-close-div">
                    @if (auth_user() && auth_user()->buyer && $game->hasReviewedGame(auth()->user()))
                        <h3>Edit Review</h3>
                    @else
                        <h3>Add Review</h3>
                    @endif
                    <button class="btn-close-review-form">Close</button>
                </div>
                @if (auth_user() && auth_user()->buyer && $game->hasReviewedGame(auth()->user()))
                    <form class="edit-review-form" action="{{ url('reviews/update') }}" method="POST">
                @else
                    <form class="add-review-form" action="{{ url('reviews/add') }}" method="POST">
                @endif
                @csrf
                @if (auth_user() && auth_user()->buyer && !$game->hasReviewedGame(auth()->user()))
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
                @else
                    <input type="hidden" name="game_id" value="{{ $game->id }}">
                    <input type="hidden" name="review_id" value="{{ $review->id ?? '' }}">
                    <div class="form-group">
                        <label for="review-title">Title</label>
                        <input type="text" class="form-control" id="review-title" name="title" value="{{ $review->title ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="review-description">Description</label>
                        <textarea class="form-control" id="review-description" name="description" rows="3" required>{{ $review->description ?? '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="review-rating">Rating</label>
                        <div class="form-check thumbs-up">
                            <input class="form-check-input" type="radio" name="positive" id="review-positive" value="true" {{ isset($review) && $review->positive ? 'checked' : '' }} required>
                            <label class="form-check-label" for="review-positive">
                                <i class="fas fa-thumbs-up" style="color: lightgreen;"></i> Positive
                            </label>
                        </div>
                        <div class="form-check thumbs-up">
                            <input class="form-check-input" type="radio" name="positive" id="review-negative" value="false" {{ isset($review) && !$review->positive ? 'checked' : '' }} required>
                            <label class="form-check-label" for="review-negative">
                                <i class="fas fa-thumbs-down" style="color: red;"></i> Negative
                            </label>
                        </div>
                    </div>
                @endif
                    <div class="btn-submit-div">
                        <button type="submit" class="btn btn-primary btn-submit">Submit Review</button>
                    </div>
                </form>
            </div>
            <!-- Reviews will be loaded here by the JS -->
        </div>
    </div>
</div>

@endsection