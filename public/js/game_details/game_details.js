function reportReviewForm(reviewId) {
    console.log("reportReviewForm appears!");
    console.log("reviewId: ", reviewId);
}

document.addEventListener('DOMContentLoaded', function() {

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

    /* Add/Edit/Cancel Review */
    const reviewForm = document.querySelector('.add-review-container');
    const reviewFormToggle = document.querySelector('.btn-review-form-toggle');
    const reviewsSection = document.querySelector('.reviews-section');

    if (!reviewFormToggle) {
        return;
    }

    reviewFormToggle.addEventListener('click', function() {
        reviewForm.style.display = reviewForm.classList.contains('visible') ? 'none' : 'block';
        reviewForm.classList.toggle('visible');
        reviewsSection.style.display = reviewForm.classList.contains('visible') ? 'none' : 'block';

        if (reviewForm.classList.contains('visible')) {
            reviewFormToggle.textContent = 'Cancel';
            reviewFormToggle.classList.add('cancel-mode');
        } else if (reviewForm.classList.contains('edit')) {
            reviewFormToggle.textContent = 'Edit My review';
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
        const regex = /[^a-zA-Z0-9\s,\.!]/g;
        event.target.value = event.target.value.replace(regex, '');
    }

    reviewTitle.addEventListener('input', restrictInput);
    reviewDescription.addEventListener('input', restrictInput);

    /* Report Review */
    const reportReviewButtons = document.querySelectorAll('.btn-report');
    reportReviewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = button.getAttribute('data-review-id');
            reportReviewForm(reviewId);
        });
    });
});