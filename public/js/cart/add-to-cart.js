document.addEventListener('DOMContentLoaded', function () {
    const addToCartButtons = document.querySelectorAll('.btn-add-to-cart');
    if (!addToCartButtons.length) {
        return;
    }
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            const productId = event.target.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('/add_product', {
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
                    fetchCartCount();
                    button.textContent = "Added to cart";
                    button.disabled = true;
                    button.style.backgroundColor = '#fff';
                    button.style.color = '#4e13a3';
                    setTimeout(() => {
                        button.textContent = "Add to cart";
                        button.style.color = '#fff';
                        button.disabled = false;
                        button.style.backgroundColor = '';
                    }, 1000);
                } else {
                    if (data.quantity_limit){
                        alert('The quantity of this product cannot exceed 10 in your cart.');
                    } else {
                        alert('An error occurred while adding the product to the cart.');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});