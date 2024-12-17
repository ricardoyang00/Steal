<script src="{{ asset('js/game_details/review_card.js') }}" defer></script>

@php
    $profilePicturePath = $review->getAuthor->user->profile_picture;
    $profilePictureFullPath = public_path($profilePicturePath);
    $profilePicture = $review->getAuthor->user->profile_picture && file_exists($profilePictureFullPath) 
        ? asset($profilePicturePath) 
        : asset('images/profile_pictures/default-profile-picture.png');
    $isOwnReview = auth_user() && auth_user()->id === $review->author;
    $isLikedByUser = auth_user() && $review->likes->contains('author', auth_user()->id);
@endphp

<div class="review-card" @if($isOwnReview) id="own-review" @endif>
    <div class="review-header">
        <div class="icon-and-username">
            <img src="{{ $profilePicture }}" alt="Profile Picture" id="review-profile-picture">
            <span class="username">{{ $review->getAuthor->user->username }}</span>
        </div>
        <div class="review-likes">
            @if ($isOwnReview || (auth_user() && auth_user()->seller) || is_admin())
                <i class="fas fa-heart" style="color: white;"></i>
            @else
                <i class="fas fa-heart like-button {{ $isLikedByUser ? 'liked' : '' }}" data-id="{{ $review->id }}" data-liked="{{ $isLikedByUser ? 'true' : 'false' }}"></i>
            @endif
            <span class="like-count">{{ $review->likes->count() }}</span>
            <span class="like-text">{{ $review->likes->count() === 1 ? ' Like' : ' Likes' }}</span>
        </div>        
    </div>

    <div class="recommendation">
        @if ($review->positive)
            <div class="recommend-box positive-box">
                <div class="thumb-icon-box positive-bg">
                    <i class="fas fa-thumbs-up"></i>
                </div>
                Recommended
            </div>
        @else
            <div class="recommend-box negative-box">
                <div class="thumb-icon-box negative-bg">
                    <i class="fas fa-thumbs-down"></i>
                </div>
                Not Recommended
            </div>
        @endif
    </div>
    
    <div class="review-content">
        <h2>{{ $review->title }}</h2>
        <p>{{ $review->description }}</p>
    </div>

    @if (!$isOwnReview)
        <button class="btn-report" data-review-id="{{ $review->id }}">
            <i class="fas fa-exclamation-triangle"></i> Report
        </button>
    @endif
</div>