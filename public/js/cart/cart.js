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
                    document.getElementById('total_price').textContent = data.new_total;
                    if (document.getElementById('product_list').childElementCount === 0) {
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
                document.getElementById('total_price').textContent = (data.new_total).toFixed(2);
                if (data.new_quantity === 0) {
                    productItem.remove();
                    if (document.getElementById('product_list').childElementCount === 0) {
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
            const noItems = document.createElement('p');
            noItems.textContent = 'No products in the cart.';
            document.getElementById('product_div').innerHTML = '';
            document.getElementById('product_div').appendChild(noItems);
        }
    }
});