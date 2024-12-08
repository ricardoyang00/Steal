document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reset-form');
    const loading = document.getElementById('loading');
    const formContainer = document.querySelector('.password-reset-form');

    form.addEventListener('submit', function(event) {
        // Show the flip animation immediately when the submit button is clicked
        formContainer.classList.add('flip');
        
        // Show the loading dots after a short delay
        setTimeout(function() {
            loading.style.display = 'block'; // Show loading dots
        }, 500); // Delay for flip animation to complete

        // Submit the form immediately
        // This will allow the form to submit in the background and show the animation
        form.submit();
    });
});
