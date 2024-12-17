document.addEventListener('DOMContentLoaded', function () {
    const likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach(button => {
        // Check if the event listener is already attached
        if (!button.dataset.listenerAttached) {
            button.addEventListener('click', async function () {
                const reviewId = this.getAttribute('data-id');
                const likeCountElement = this.nextElementSibling; // Span for number of likes
                const likeTextElement = likeCountElement.nextElementSibling; // Span for "Like/Likes" text
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const isLiked = this.getAttribute('data-liked') === 'true';

                console.log(`Initial data-liked attribute: ${this.getAttribute('data-liked')}`);

                // Prevent multiple clicks by disabling the button
                this.disabled = true;

                try {
                    console.log(`Sending request to like/unlike review with ID: ${reviewId}, isLiked: ${isLiked}`);
                    // Send the like/unlike request to the server
                    const response = await fetch(`/reviews/${reviewId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ review_id: reviewId, liked: isLiked }),
                    });

                    if (response.redirected) {
                        // If the response is a redirect, go to the new URL
                        window.location.href = response.url;
                        return;
                    }

                    const data = await response.json();
                    console.log('Response from server:', data);

                    if (data.success) {
                        const newLikesCount = data.likes_count;

                        // Only update if the like count has changed
                        if (likeCountElement.textContent != newLikesCount) {
                            likeCountElement.textContent = newLikesCount;
                        }

                        // Determine whether to show "Like" or "Likes"
                        const newText = newLikesCount === 1 ? ' Like' : ' Likes';
                        if (likeTextElement.textContent !== newText) {
                            likeTextElement.textContent = newText;
                        }

                        // Toggle the "liked" class to reflect the user's action
                        this.classList.toggle('liked');
                        this.setAttribute('data-liked', !isLiked);
                        console.log(`Updated data-liked attribute to: ${!isLiked}`);
                    } else {
                        alert(data.message); // Show any error messages returned from the server
                    }
                } catch (error) {
                    console.error('Error liking review:', error); // Log any errors
                } finally {
                    // Re-enable the button after the request has been processed
                    this.disabled = false;
                }
            });

            // Mark the event listener as attached
            button.dataset.listenerAttached = 'true';
        }
    });
});