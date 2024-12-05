document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.input-wrapper input');

    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value) {
                this.parentNode.classList.add('input-filled');
            } else {
                this.parentNode.classList.remove('input-filled');
            }
        });

        // Trigger the input event on page load to set the initial state
        input.dispatchEvent(new Event('input'));
    });
});