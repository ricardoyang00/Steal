@extends('layouts.app')

@section('title', $game->name)

@section('content')

@if (!auth_user() || auth_user()->buyer)
    <script src="{{ asset('js/wishlist/add-to-wishlist.js') }}" defer></script>
    <script src="{{ asset('js/cart/add-to-cart.js') }}" defer ></script>
    <script src="{{ asset('js/reviews/report_review.js') }}" defer ></script>
@endif

<script src="{{ asset('js/game_details/game_details.js') }}" defer></script>
<script src="{{ asset('js/common/confirmation-modal.js') }}" defer></script>
<script src="{{ asset('js/admin/block-modal.js') }}" defer></script>

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
                    @if ($game->images && count($game->images) > 0)
                        @foreach($game->images as $image)
                            @php
                                $imagePath = public_path($image->path);
                                $imageUrl = file_exists($imagePath) ? asset($image->path) : asset('images/thumbnail_large/default_thumbnail_large.jpg');
                            @endphp
                            <div class="carousel-item">
                                <img src="{{ $imageUrl }}" class="img-fluid" alt="{{ $game->name }}">
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item">
                            <img src="{{ asset($game->getThumbnailLargePath()) }}" class="img-fluid" alt="{{ $game->name }}">
                        </div>
                    @endif
                </div>
                <div class="carousel-pagination-controls" data-total-items="{{ count($game->images) }}">
                    @if (count($game->images) > 0)
                        @foreach ($game->images as $index => $image)
                            <button class="carousel-pagination-btn" onclick="showCarouselItem({{ $index }})">{{ $index + 1 }}</button>
                        @endforeach
                    @else
                        <button class="carousel-pagination-btn active" onclick="showCarouselItem(0)">1</button>
                    @endif
                </div>
                @if (count($game->images) > 1)
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
                <p class="game-price"><strong>€{{ $game->price }}</strong></p>
                @if (!auth_user() || auth_user()->buyer)
                    <button id="add-to-cart-{{ $game['id'] }}" data-id="{{ $game['id'] }}" class="btn-add-to-cart btn btn-primary">
                        Add to Cart
                    </button>
                @elseif (is_admin())
                    @if ($game->is_active)
                        @include('partials.admin.block-modal')
                        <form action="{{ route('admin.games.block', $game->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="button" class="btn btn-primary" id="block-game" onclick="showBlockModal({{ $game->id }})">Block</button>
                    @else
                        @include('partials.common.confirmation-modal')
                        <form action="{{ route('admin.games.unblock', $game->id) }}" method="POST" style="display:inline;" id="unblock-game-form">
                            @csrf
                            <button type="button" class="confirmation-btn btn btn-primary" id="btn-unblock"
                                    data-title="Unblock Game"
                                    data-message="Are you sure you want to unblock {{ $game->name }} ?"
                                    data-form-id="unblock-game-form">
                                Unblock
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <div class="game-reviews" data-id="{{ $game->id }}">
        <div class="reviews-bar">
            <!-- Rating -->
            <div class="rating-container">
                <p>Overall Reviews</p>
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
                <p>{{ count($game->reviews) }} {{ count($game->reviews) == 1 ? 'Review' : 'Reviews' }} </p>
            </div>

            <div class="review-bar-end">
                @if (auth_user() && auth_user()->buyer)
                    @if (auth()->user()->hasDeliveredPurchase($game->id) && !$game->hasReviewedGame(auth()->user()))
                        <div class="review-buttons">
                            <button class="btn-review-form-toggle">Add Review</button>
                        </div>
                    @elseif (!$game->hasReviewedGame(auth()->user()))
                        <p class="review-buttons">
                            You must have purchased this game to leave a review
                        </p>
                    @elseif ($game->hasReviewedGame(auth()->user()))
                        <div class="review-buttons">
                            <button class="btn-review-form-toggle">Edit Review</button>
                            @include('partials.common.confirmation-modal')
                            <form action="{{ route('reviews.delete', ['id' => $userReview->id]) }}" method="POST" id="remove-review-form" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="confirmation-btn btn btn-primary" id="btn-review-remove"
                                        data-title="Remove Review"
                                        data-message="Are you sure you want to remove your review?"
                                        data-form-id="remove-review-form">
                                    Remove Review
                                </button>
                            </form>
                        </div>
                    @endif
                @elseif (!auth_user())
                    <p class="review-buttons">
                        You must be logged in to leave a review
                    </p>
                @elseif (is_admin() || (auth_user()->seller))
                    <p class="review-buttons">
                        You cannot review games
                    </p>
                @endif
            </div>
        </div>
        
        <div class="reviews">
            @php
                $isAuthor = auth_user() && auth_user()->buyer && $game->hasReviewedGame(auth()->user());
            @endphp
        
            <div class="add-review-container {{ $isAuthor ? 'edit' : '' }}" style="display: none;">
                <div class="btn-close-div">
                    <h3>{{ $isAuthor ? 'Edit Review' : 'Add Review' }}</h3>
                </div>
                <form class="{{ $isAuthor ? 'edit-review-form' : 'add-review-form' }}" action="{{ url($isAuthor ? 'reviews/update' : 'reviews/add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $game->id }}">
                    @if ($isAuthor)
                        <input type="hidden" name="review_id" value="{{ $userReview->id ?? '' }}">
                    @endif
                    <div class="form-group">
                        <label for="review-title">Title</label>
                        <input type="text" class="form-control" id="review-title" name="title" value="{{ $isAuthor ? $userReview->title ?? '' : '' }}" maxlength="100" required>
                    </div>
                    <div class="form-group">
                        <label for="review-description">Description</label>
                        <textarea class="form-control" id="review-description" name="description" rows="3" maxlength="500" required>{{ $isAuthor ? $userReview->description ?? '' : '' }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="review-rating">Rating</label>
                        <div class="form-check thumbs-up">
                            <input class="form-check-input" type="radio" name="rating" id="review-positive" value="true" {{ $isAuthor && isset($userReview) && $userReview->positive ? 'checked' : '' }} required>
                            <label class="form-check-label" for="review-positive">
                                <i class="fas fa-thumbs-up" style="color: #4ab757;"></i> Positive
                            </label>
                        </div>
                        <div class="form-check thumbs-up">
                            <input class="form-check-input" type="radio" name="rating" id="review-negative" value="false" {{ $isAuthor && isset($userReview) && !$userReview->positive ? 'checked' : '' }} required>
                            <label class="form-check-label" for="review-negative">
                                <i class="fas fa-thumbs-down" style="color: #b7574a;"></i> Negative
                            </label>
                        </div>
                    </div>
                    <div class="btn-submit-div">
                        <button type="submit" class="btn btn-primary btn-submit">Submit Review</button>
                    </div>
                </form>
            </div>

            <div class="reviews-section">
                @if ($reviews->isEmpty())
                    <p class="no-reviews-message">
                        There are no reviews for this game yet
                    </p>
                @else
                    @foreach ($reviews as $review)
                        @include('partials.review.review-card', ['review' => $review])

                        <div id="report-review-modal" class="modal">
                            <div class="modal-content">
                                <span class="close report-review-close-button">&times;</span>
                                <div class="modal-header">
                                    <h2>Report Review</h2>
                                </div>
                                <div class="modal-body report-review-body">
                                    <form id="report-review-form" action="/reviews/report" method="POST">
                                        @csrf
                                        <input id="review-id-input" type="hidden" name="review_id" value="{{ $review->id }}">
                                        <div class="form-group">
                                            <label for="report-reason">Reason</label>
                                            <select id="report-reason" name="reason_id" class="form-control" required>
                                                @foreach ($reportReasons as $reason)
                                                    <option value="{{ $reason->id }}">{{ $reason->description }}</option>
                                                @endforeach
                                                <option value="">Other</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="report-description">Description</label>
                                            <textarea id="report-description" name="description" class="form-control" rows="3" maxlength="500" placeholder="You do not have to provide a description, but it is required if 'Other' is selected."></textarea>
                                        </div>
                                        <button type="submit" class="btn-report-submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    @endforeach

                    <!-- Pagination Links -->
                    <div class="pagination-links">
                        {{ $reviews->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection