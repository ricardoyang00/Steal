document.addEventListener('DOMContentLoaded', function() {
    const reportReviewButtons = document.querySelectorAll('.btn-report');    const reportReviewForm = document.getElementById('report-review-form');
    const reportReviewModal = document.getElementById('report-review-modal');
    const reportReviewCloseButton = document.querySelector('.report-review-close-button');
    const reportReviewSubmitButton = document.querySelector('.btn-report-submit');

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

    reportReviewSubmitButton.addEventListener('click', function() {
        reportReviewForm.submit();
    });

    reportReviewForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const reviewId = reportReviewForm.querySelector('input[name="review_id"]').value;
        const reason = reportReviewForm.querySelector('select[name="reason"]').value;
        const description = reportReviewForm.querySelector('textarea[name="description"]').value;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/reviews/report', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ review_id: reviewId, reason: reason, description: description }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                reportReviewModal.classList.remove('active');
                alert('Review reported successfully.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
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