<div class="review-card">
    <div class="review-header">
        @if ($review->positive)
            <i class="fas fa-thumbs-up" style="color: #4ab757;"></i>
        @else
            <i class="fas fa-thumbs-down" style="color: #b7574a;"></i>
        @endif
        <p>{{ $review->getAuthor->user->username; }}</p>
    </div>
    <h4>{{ $review->title }}</h4>
    <p>{{ $review->description }}</p>
    <button class="btn-report" data-id="{{ $review->id }}">Report</button>
</div>