document.addEventListener('DOMContentLoaded', function() {
    const wishlistButtons = document.querySelectorAll('.add-to-wishlist');
    wishlistButtons.forEach(button => {
        const productId = button.getAttribute('data-id');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('/wishlist/is_in_wishlist', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ game_id: productId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.is_in_wishlist) {
                console.log("Product is in wishlist");
                heartBtnActive(button);
                button.removeEventListener('click', addProductToWishlist);
                button.addEventListener('click', removeProductFromWishlist);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

function heartBtnActive(button) {
    const icon = button.querySelector('i');
    icon.classList.remove('far');
    icon.classList.add('fas');
    icon.style.color = 'red';
}