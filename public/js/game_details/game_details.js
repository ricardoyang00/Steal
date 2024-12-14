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
});