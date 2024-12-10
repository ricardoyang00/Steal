document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-buttons #filter-user-search');

    // Check if any button is active, if not, set the "All" button as active
    const activeButton = document.querySelector('.filter-buttons #filter-user-search.active');
    if (!activeButton) {
        const allButton = document.querySelector('.filter-buttons #filter-user-search[value="all"]');
        if (allButton) {
            allButton.classList.add('active');
        }
    }

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