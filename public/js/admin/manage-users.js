document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-buttons #filter-user-search');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove the active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            
            // Add the active class to the clicked button
            button.classList.add('active');

            // Allow the button to submit the form
        });
    });
});
