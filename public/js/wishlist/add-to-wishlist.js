document.addEventListener('DOMContentLoaded', function () {
    const addToWishlistButtons = document.querySelectorAll('.btn-add-to-wishlist');
    addToWishlistButtons.forEach(button => {
        button.addEventListener('click', addProductToWishlist);

        button.addEventListener('mouseout', function() {
            if (button.classList.contains('active')) {
                return;
            }
            const icon = button.querySelector('i');
            icon.classList.remove('fas');
            icon.classList.add('far');
        });
    });
});

function heartBtnActive(button) {
    const icon = button.querySelector('i');
    button.classList.add('active');
    icon.classList.remove('far');
    icon.classList.add('fas');
    icon.style.color = 'red';
}

function heartBtnInactive(button) {
    const icon = button.querySelector('i');
    button.classList.remove('active');
    icon.classList.remove('fas');
    icon.classList.add('far');
    icon.style.color = '';
}

function addProductToWishlist(event) {
    const button = event.currentTarget;
    const productId = button.getAttribute('data-id');
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
            heartBtnActive(button);
            button.removeEventListener('click', addProductToWishlist);
            button.addEventListener('click', removeProductFromWishlist);
        } else {
            alert('An error occurred while adding the product to the wishlist.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while adding the product to the wishlist.');
    });
}

function removeProductFromWishlist(event) {
    const button = event.currentTarget;
    const productId = button.getAttribute('data-id');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/wishlist/remove', {
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
            heartBtnInactive(button);
            button.removeEventListener('click', removeProductFromWishlist);
            button.addEventListener('click', addProductToWishlist);
        } else {
            alert('An error occurred while removing the product from the wishlist.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while removing the product from the wishlist.');
    });
}