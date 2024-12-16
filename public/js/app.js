function scrollToSection(event, sectionId) {
    event.preventDefault();
    document.getElementById(sectionId).scrollIntoView({
        behavior: 'smooth'
    });
}
function fetchCartCount() {
    fetch('/cart/count', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(response => response.json())
        .then(data => {
            if (data?.count !== undefined) {
                const countElement = document.getElementById('cart-count');
                if (countElement) {
                    countElement.textContent = data.count > 0 ? data.count : '';
                    countElement.style.display = data.count > 0 ? 'inline-block' : 'none';
                }
            }
        })
        .catch(error => console.error('Error fetching cart count.', error));
}

document.addEventListener('DOMContentLoaded', function() {
    var successNotification = document.querySelector('.alert-success.notification-popup');
    var errorNotification = document.querySelector('.alert-error.notification-popup');

    if (successNotification) {
        successNotification.style.display = 'block';
        setTimeout(function() {
            successNotification.style.display = 'none';
        }, 3000); // Hide after 3 seconds
    }

    if (errorNotification) {
        errorNotification.style.display = 'block';
        setTimeout(function() {
            errorNotification.style.display = 'none';
        }, 3000); // Hide after 3 seconds
    }

    fetchCartCount();
});