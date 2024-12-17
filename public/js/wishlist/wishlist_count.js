function updateWishlistCount() {
    console.log('updated wishlist count');
    fetch('/wishlist/w_count', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data?.count !== undefined) {
                const countElement = document.getElementById('wishlist-count');
                const countDiv = document.getElementById('w_count_div');
                if (countElement) {
                    if (data.count > 0) {
                        countElement.style.display = 'inline-block';
                        countDiv.style.display = 'inline-block';
                        countElement.textContent = data.count;
                    } else {
                        countElement.style.display = 'none';
                        countDiv.style.display = 'none';
                    }
                }
                console.log('wishlist count: ', data.count);
            }
        })
        .catch(error => console.error('Error fetching wishlist count.', error));
}

document.addEventListener('DOMContentLoaded', updateWishlistCount);