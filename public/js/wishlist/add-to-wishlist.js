document.addEventListener('DOMContentLoaded', function () {
    const addToWishlistButtons = document.querySelectorAll('.btn-add-to-wishlist');
    if (!addToWishlistButtons.length) {
        return;
    }
    addToWishlistButtons.forEach(button => {
        console.log("button added: ", button);
        button.addEventListener('click', function (event) {
            const productId = event.currentTarget.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log("productId: ", productId);
            fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ game_id: productId }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    button.disabled = true;
                    button.style.color = 'red';
                    const heartIcon = button.querySelector('.fas.fa-heart');
                    heartIcon.classList.remove('far');
                    heartIcon.classList.add('fas');
                } else {
                    alert('An error occurred while adding the product to the wishlist.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});