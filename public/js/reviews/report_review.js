document.addEventListener('DOMContentLoaded', function() {
    const reportReviewButtons = document.querySelectorAll('.btn-report');    const reportReviewForm = document.getElementById('report-review-form');
    const reportReviewCloseButton = document.querySelector('.report-review-close-button');

    reportReviewButtons.forEach(button => {
        button.addEventListener('click', function() {
            showModal(
                button.getAttribute('data-review-id'),
                button.getAttribute('data-author-id')
            );
        });
    });

    reportReviewCloseButton.addEventListener('click', function() {
        closeModal();
    });
});

function showModal(reviewId, authorId) {
    const modal = document.getElementById('report-review-modal');
    const modalContent = modal.querySelector('.modal-content h2');
    modalContent.textContent = `Report Review by ${authorId}`;
    if (modal) {
        modal.style.display = 'block';
        modal.querySelector('#review-id-input').value = reviewId;
    }
}

function closeModal() {
    const modal = document.getElementById('report-review-modal');
    if (modal) {
        modal.style.display = 'none';
    }
}