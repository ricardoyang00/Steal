document.addEventListener('DOMContentLoaded', function() {
    const wishlistButtons = document.querySelectorAll('.add-to-wishlist');

    wishlistButtons.forEach(button => {
        button.addEventListener('mouseover', function() {
            const icon = button.querySelector('i');
            icon.classList.remove('far');
            icon.classList.add('fas');
        });

        button.addEventListener('mouseout', function() {
            const icon = button.querySelector('i');
            icon.classList.remove('fas');
            icon.classList.add('far');
        });
    });
});