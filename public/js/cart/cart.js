document.addEventListener('DOMContentLoaded', function () {
    const productList = document.getElementById('product_list');

    if (!productList) {
        return;
    }

    function disableDecrementButtons() {
        const productItems = document.querySelectorAll('#product_list .product-container');
        productItems.forEach(productItem => {
            const quantityElement = productItem.querySelector('.prod_quantity');
            const decreaseButton = productItem.querySelector('.btn-decrease');
            if (parseInt(quantityElement.textContent) === 1) {
                decreaseButton.disabled = true;
            }
        });
    }

    disableDecrementButtons();

    function disableIncrementButton(incBtn) {
        if (parseInt(incBtn.previousElementSibling.textContent) === 10) {
            incBtn.disabled = true;
        }
    }

    const incrementButtons = document.querySelectorAll('.btn-increase');
    incrementButtons.forEach(disableIncrementButton);

    productList.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-increase')) {
            const productId = event.target.getAttribute('data-id');
            updateQuantity(productId, 'increase');
            // check if the quantities are bigger than 9 to disable the buttons
            const productItem = document.getElementById(`product-${productId}`);
            const quantityElement = productItem.querySelector('.prod_quantity');
            const decreaseButton = productItem.querySelector('.btn-decrease');
            if (parseInt(quantityElement.textContent) === 9) {
                event.target.disabled = true;
            }
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
                    document.getElementById('total_price').textContent = '€ ' + data.new_total.toFixed(2);
                    document.getElementById('subtotal').textContent = '€ ' + data.new_total.toFixed(2);
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
            // check if product quantity is smaller than 10 and enable the increase button
            const productItem = document.getElementById(`product-${productId}`);
            const quantityElement = productItem.querySelector('.prod_quantity');
            const increaseButton = productItem.querySelector('.btn-increase');
            if (parseInt(quantityElement.textContent) === 10) {
                increaseButton.disabled = false;
            }
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
                totalPriceElement.textContent = '€ ' + data.new_total.toFixed(2);
                    
                // Update the subtotal and discount based on the number of coins used
                updateDiscountAndSubtotal(data.new_total);
        
                // Disable the decrement button if quantity is 1
                const decreaseButton = productItem.querySelector('.btn-decrease');
                if (data.new_quantity === 1) {
                    decreaseButton.disabled = true;
                } else {
                    decreaseButton.disabled = false;
                }

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

            // Hide the coins section
            const coinsSection = document.querySelector('.coins-section');
            if (coinsSection) {
                coinsSection.style.display = 'none';
            }
        }
    }

    // Add event listener to coins input to update discount and subtotal
    const coinsInput = document.getElementById('coins_to_use');
    if (coinsInput) {
        coinsInput.addEventListener('input', function () {
            // Ensure only valid numbers are input
            let coinsToUse = parseInt(coinsInput.value) || 0;
            const maxCoins = parseInt(coinsInput.getAttribute('max'));
            const total = parseFloat(document.getElementById('total_price').textContent.replace('€', '').trim());

            // Calculate the maximum coins that can be used without making the subtotal less than €0.01
            const maxCoinsAllowed = Math.min(maxCoins, Math.floor((total - 0.01) * 100));

            // Prevent negative values and values greater than maxCoinsAllowed
            if (coinsToUse < 0) {
                coinsToUse = 0;
            } else if (coinsToUse > maxCoinsAllowed) {
                coinsToUse = maxCoinsAllowed;
            }

            coinsInput.value = coinsToUse;

                // Update the hidden input field value
            const hiddenCoinsInput = document.getElementById('coins_to_use_hidden');
            if (hiddenCoinsInput) {
                hiddenCoinsInput.value = coinsToUse;
            }

            updateDiscountAndSubtotal(total);
        });
    }

    function updateDiscountAndSubtotal(total) {
        const coinsInput = document.getElementById('coins_to_use');
        const discountElement = document.getElementById('discount');
        const subtotalElement = document.getElementById('subtotal');
        const coinsToUse = parseInt(coinsInput.value) || 0;
        const discount = coinsToUse * 0.01; // 1 coin equals to 0.01 euro
        const newSubtotal = total - discount;

        discountElement.textContent = `- € ${discount.toFixed(2)}`;
        subtotalElement.textContent = `€ ${newSubtotal.toFixed(2)}`;
    }

    const checkoutButton = document.getElementById('checkout_button');
    checkoutButton.addEventListener('click', function (event) {
        const coinsToUse = parseInt(document.getElementById('coins_to_use').value) || 0;
    
        fetch('/checkout/store-coins', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ coins_to_use: coinsToUse }),
        })
        .then(response => {
            if (response.ok) {
                const isAuthenticated = checkoutButton.getAttribute('data-authenticated') === 'true';
                if (isAuthenticated) {
                    window.location.href = '/checkout/payment';
                } else {
                    window.location.href = '/login';
                }
            } else {
                alert('Failed to store coins. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });    
});