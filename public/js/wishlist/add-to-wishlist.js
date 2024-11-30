document.addEventListener('DOMContentLoaded', function () {
    const addToWishlistButtons = document.querySelectorAll('.btn-add-to-wishlist');
    if (!addToWishlistButtons.length) {
        return;
    }
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            const productId = event.target.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
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
                    button.textContent = "Added to wishlist.";
                    button.disabled = true;
                    button.style.backgroundColor = 'gray';
                    setTimeout(() => {
                        button.disabled = false;
                        button.style.color = 'red';
                    }, 1000);
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