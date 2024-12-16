function scrollToSection(event, sectionId) {
    event.preventDefault();
    document.getElementById(sectionId).scrollIntoView({
        behavior: 'smooth'
    });
}

// Function to update the coins value
function updateCoins() {
    fetch('/api/coins')
        .then(response => response.json())
        .then(data => {
            if (data.coins) {
                const scoinsElement = document.getElementById('scoins');
                if (scoinsElement) {
                    scoinsElement.innerHTML = `<i class="fa-solid fa-coins"></i> <strong>${data.coins}</strong>`;
                }
            }
        })
        .catch(error => console.error('Error fetching coins:', error));
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

    if (window.location.pathname === '/checkout') {
        updateCoins(); // Call function to update coins on page load
    }
});
