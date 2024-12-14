document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM fully loaded and parsed');

    /* Images Carousel */
    const carouselInner = document.querySelector('.carousel-inner');
    const carouselItems = document.querySelectorAll('.carousel-item');
    const paginationButtons = document.querySelectorAll('.carousel-pagination-btn');
    let currentIndex = 0;

    function updateCarousel() {
        const offset = -currentIndex * 100;
        carouselInner.style.transform = `translateX(${offset}%)`;
        updatePaginationButtons();
    }

    function updatePaginationButtons() {
        paginationButtons.forEach((button, index) => {
            button.classList.toggle('active', index === currentIndex);
        });
    }

    window.prevSlide = function() {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : carouselItems.length - 1;
        updateCarousel();
    };

    window.nextSlide = function() {
        currentIndex = (currentIndex < carouselItems.length - 1) ? currentIndex + 1 : 0;
        updateCarousel();
    };

    window.showCarouselItem = function(index) {
        currentIndex = index;
        updateCarousel();
    };

    // Initialize the carousel to show the first item
    updateCarousel();
    /*              */

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
                iconFas.style.color = '#4ab757';
            } else {
                iconFas.classList.add('fas', 'fa-thumbs-down');
                iconFas.style.color = '#b7574a';
            }

            reviewElement.innerHTML = `
                <div class="review-header">
                    ${iconFas.outerHTML}
                    <p>${review.author}</p>
                    </div>
                <h4>${review.title}</h4>
                <p>${review.description}</p>
                <button class="btn-report" data-id="${review.id}">Report</button>
            `;
            reviewsContainer.appendChild(reviewElement);
        });
    })
    .catch(error => console.error('Error fetching reviews:', error));

    const reportBtns = document.querySelectorAll('.btn-report');
    reportBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            console.log("button clicked");
            reviewId = btn.getAttribute('data-id');
            console.log("review id: ", reviewId);
            fetch('/reviews/report', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ review_id: reviewId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("received response");
                    alert('Review reported successfully.');
                }
            })
            .catch(error => console.error('Error reporting review:', error));
        });
    });

    /* Add/Edit/Cancel Review */
    const reviewForm = document.querySelector('.add-review-container');
    const reviewFormToggle = document.querySelector('.btn-review-form-toggle');
    if (!reviewFormToggle) {
        return;
    }
    reviewFormToggle.addEventListener('click', function() {
        reviewForm.style.display = reviewForm.classList.contains('visible') ? 'none' : 'block';
        reviewForm.classList.toggle('visible');
        if (reviewForm.classList.contains('visible')) {
            reviewFormToggle.textContent = 'Cancel';
            reviewFormToggle.classList.add('cancel-mode');
        } else if (reviewForm.classList.contains('edit')) {
            reviewFormToggle.textContent = 'Edit review';
            reviewFormToggle.classList.remove('cancel-mode');
        } else {
            reviewFormToggle.textContent = 'Add review';
            reviewFormToggle.classList.remove('cancel-mode');
        }
    });

    /* Review Text Restrictions */
    const reviewTitle = document.getElementById('review-title');
    const reviewDescription = document.getElementById('review-description');

    function restrictInput(event) {
        const regex = /[^a-zA-Z0-9\s]/g;
        event.target.value = event.target.value.replace(regex, '');
    }

    reviewTitle.addEventListener('input', restrictInput);
    reviewDescription.addEventListener('input', restrictInput);


    const removeReviewBtns = document.querySelectorAll('.btn-review-remove');
    removeReviewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            console.log("button clicked");
            reviewId = btn.getAttribute('data-id');
            console.log("review id: ", reviewId);
            fetch('/reviews/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ review_id: reviewId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("received response");
                    window.location.href = `/game/${gameId}`;
                    alert('Review removed successfully.');
                }
            })
            .catch(error => console.error('Error removing review:', error));
        });
    });
});