document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');
    const reviewsContainer = document.querySelector('.reviews');
    if (!reviewsContainer) {
        return;
    }
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const gameId = document.querySelector('.game-reviews').getAttribute('data-id');
    fetch('/reviews', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
        body: JSON.stringify({ game_id: gameId }),
    })
    .then(response => response.json())
    .then(data => {
        data.reviews.reverse().forEach(review => {
            
            const reviewElement = document.createElement('div');
            reviewElement.classList.add('review-card');
            
            const iconFas = document.createElement('i');
            if (review.positive) {
                iconFas.classList.add('fas', 'fa-thumbs-up');
                iconFas.style.color = 'lightgreen';
            } else {
                iconFas.classList.add('fas', 'fa-thumbs-down');
                iconFas.style.color = 'red';
            }

            reviewElement.innerHTML = `
                <div class="review-header">
                    ${iconFas.outerHTML}
                    <p>${review.author}</p>
                    </div>
                <h4>${review.title}</h4>
                <p>${review.description}</p>
            `;
            reviewsContainer.appendChild(reviewElement);
        });
    })
    .catch(error => console.error('Error fetching reviews:', error));

    const reviewForm = document.querySelector('.add-review-container');
    const reviewFormToggle = document.querySelector('.btn-review-form-toggle');
    if (!reviewFormToggle) {
        return;
    }
    reviewFormToggle.addEventListener('click', function() {
        reviewForm.style.display = reviewForm.classList.contains('visible') ? 'none' : 'block';
        reviewForm.classList.toggle('visible');
        reviewFormToggle.textContent = reviewForm.classList.contains('visible') ? 'Close review form' : 'Add review';
    });

    const closeReviewForm = document.querySelector('.btn-close-review-form');
    closeReviewForm.addEventListener('click', function() {
        reviewForm.style.display = 'none';
        reviewForm.classList.remove('visible');
        reviewFormToggle.textContent = 'Add review';
    });
});