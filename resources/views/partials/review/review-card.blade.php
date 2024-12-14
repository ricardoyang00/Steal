@php
    $profilePicturePath = $review->getAuthor->user->profile_picture;
    $profilePictureFullPath = public_path($profilePicturePath);
    $profilePicture = $review->getAuthor->user->profile_picture && file_exists($profilePictureFullPath) 
        ? asset($profilePicturePath) 
        : asset('images/profile_pictures/default-profile-picture.png');
@endphp

<div class="review-card">
    <div class="review-header">
        <div class="icon-and-username">
            <img src="{{ $profilePicture }}" alt="Profile Picture" id="review-profile-picture">
            <span class="username">{{ $review->getAuthor->user->username }}</span>
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

    <button class="btn-report" data-id="{{ $review->id }}">Report</button>
</div>
