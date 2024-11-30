document.addEventListener('DOMContentLoaded', function () {
    const productList = document.getElementById('product_list');
    if (!productList) {
        return;
    }
    productList.addEventListener('click', function (event) {
        if (event.target.classList.contains('btn-remove')) {
            const productId = event.target.getAttribute('data-id');
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
                    document.getElementById(`product-${productId}`).remove();
                    // change background to red
                    document.getElementById(`product-${productId}`).style.backgroundColor = 'red';
                    if (document.getElementById('product_list').childElementCount === 0) {
                        noProductsInWishlist();
                    }
                } else {
                    alert('An error occurred while removing the product.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});

function noProductsInWishlist() {
    const productList = document.getElementById('product_list');
    const noProducts = document.createElement('p');
    noProducts.textContent = 'No products in wishlist.';
    productList.appendChild(noProducts);
}