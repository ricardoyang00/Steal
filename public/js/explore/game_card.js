document.addEventListener('DOMContentLoaded', function() {
    const gameCards = document.querySelectorAll('.game-card');

    gameCards.forEach(card => {
        card.addEventListener('click', function(event) {
            // Prevent the click event from propagating if the target is a button or link
            if (event.target.tagName !== 'BUTTON' && event.target.tagName !== 'A' && !event.target.closest('.add-to-wishlist')) {
                window.location.href = card.getAttribute('data-url');
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const wishlistButtons = document.querySelectorAll('.add-to-wishlist');

    wishlistButtons.forEach(button => {
        button.addEventListener('mouseover', function() {
            const icon = button.querySelector('i');
            icon.classList.remove('far');
            icon.classList.add('fas');
        });

        button.addEventListener('mouseout', function() {
            if (button.disabled) {
                return;
            }
            const icon = button.querySelector('i');
            icon.classList.remove('fas');
            icon.classList.add('far');
        });
    });
});