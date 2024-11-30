document.addEventListener('DOMContentLoaded', function () {
    const addToWishlistButtons = document.querySelectorAll('.btn-add-to-wishlist');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            const productId = event.currentTarget.getAttribute('data-id');
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
                    button.disabled = true;
                    heartBtnActive(button);
                } else {
                    alert('An error occurred while adding the product to the wishlist.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the product to the wishlist.');
            });
        });
    });
});

function heartBtnActive(button) {
    const icon = button.querySelector('i');
    icon.classList.remove('far');
    icon.classList.add('fas');
    icon.style.color = 'red';
}