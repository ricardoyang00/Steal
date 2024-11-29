document.addEventListener('DOMContentLoaded', function () {
    const productList = document.getElementById('product_list');

    if (!productList) {
        return;
    }

    productList.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-increase')) {
            const productId = event.target.getAttribute('data-id');
            updateQuantity(productId, 'increase');
        }

        if (event.target.classList.contains('btn-remove')) {
            const productId = event.target.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch('remove_product', {
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
                    document.getElementById(`product-${productId}`).remove();
                    document.getElementById('total_price').textContent = (data.new_total).toFixed(2) + '€';
                    document.getElementById('subtotal').textContent = (data.new_total).toFixed(2) + '€';
                    if (productList.childElementCount === 0) {
                        noProductsInCart();
                    }
                } else {
                    alert('An error occurred while removing the product.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        if (event.target.classList.contains('btn-decrease')) {
            const productId = event.target.getAttribute('data-id');
            updateQuantity(productId, 'decrease');
        }
    });

    function updateQuantity(productId, action) {
        console.log('productId:', productId);
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        console.log("here I am in updateQuantity");
        fetch(action + "_quantity", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify({ game_id: productId }),
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response data: ", data.text);
            if (data.success) {
                const productItem = document.getElementById(`product-${productId}`);
                productItem.querySelector('.prod_quantity').textContent = data.new_quantity;

                // Update the total price
                const totalPriceElement = document.getElementById('total_price');
                totalPriceElement.textContent = (data.new_total).toFixed(2) + '€';

                // Update the subtotal (same as total for now since no discounts applied)
                const subtotalElement = document.getElementById('subtotal');
                subtotalElement.textContent = (data.new_total).toFixed(2) + '€';
                
                if (data.new_quantity === 0) {
                    productItem.remove();
                    if (productList.childElementCount === 0) {
                        noProductsInCart();
                    }
                }
            } else {
                alert('An error occurred while updating the quantity.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function noProductsInCart() {
        if (document.getElementById('product_list').childElementCount === 0) {
            const emptyCartMessage = document.createElement('div');
            emptyCartMessage.classList.add('empty-cart-message');
            emptyCartMessage.innerHTML = `
                <i class="fas fa-shopping-cart"></i>
                <p id="primary-empty-message">Your cart is empty</p>
                <p id="secondary-empty-message">You didn't add any item in your cart yet. Browse the website to find amazing deals!</p>
                <a href="/explore" class="btn">Explore games</a>
            `;
            productList.appendChild(emptyCartMessage);
            document.querySelector('.cart-items').classList.add('empty-cart');

            // Disable the checkout button and change its appearance
            const checkoutButton = document.getElementById('checkout_button');
            if (checkoutButton) {
                checkoutButton.classList.add('disabled');
                checkoutButton.disabled = true;
            }
        }
    }
});

const checkoutButton = document.getElementById('checkout_button');
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function () {
            const isAuthenticated = checkoutButton.getAttribute('data-authenticated') === 'true';

            if (isAuthenticated) {
                // Redirect to the payment method selection page
                window.location.href = '/checkout/payment';
            } else {
                // Alert the user and redirect to the login page
                alert('You must be logged in as a buyer to proceed to checkout.');
                window.location.href = '/login';
            }
        });
    }