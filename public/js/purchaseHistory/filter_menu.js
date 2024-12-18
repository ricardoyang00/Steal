// public/js/purchaseHistory/filter_menu.js

document.addEventListener('DOMContentLoaded', function () {
    // Select the filter button by its ID
    const filterButton = document.getElementById('purchase-history-filter-dropdownButton');

    // Select the filter container to toggle the 'active' class
    const filterContainer = document.querySelector('.purchase-history-filter-dropdown');

    // Function to toggle the filter dropdown
    function toggleFilterDropdown() {
        filterContainer.classList.toggle('active'); // Toggle the 'active' class
        const isActive = filterContainer.classList.contains('active');

        // Update ARIA attribute for accessibility
        filterButton.setAttribute('aria-expanded', isActive);
    }

    // Event listener for the filter button click
    filterButton.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent the click from propagating to the window
        toggleFilterDropdown(); // Toggle the filter dropdown

        // Optional: Close the sort dropdown if it's open
        const sortContainer = document.querySelector('.purchase-history-dropdown.active');
        if (sortContainer && sortContainer !== filterContainer) {
            sortContainer.classList.remove('active');
            const sortButton = sortContainer.querySelector('.purchase-history-dropdownButton');
            if (sortButton) {
                sortButton.setAttribute('aria-expanded', false);
            }
        }
    });

    // Optional: Close the filter dropdown when clicking outside
    // If you have a separate 'dropdown_close.js', consider removing this block to prevent redundancy
    window.addEventListener('click', function (e) {
        if (!filterContainer.contains(e.target) && !filterButton.contains(e.target)) {
            if (filterContainer.classList.contains('active')) {
                filterContainer.classList.remove('active');
                filterButton.setAttribute('aria-expanded', false);
            }
        }
    });

    // Optional: Close filter dropdown when pressing the Escape key
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && filterContainer.classList.contains('active')) {
            filterContainer.classList.remove('active');
            filterButton.setAttribute('aria-expanded', false);
            filterButton.focus(); // Return focus to the filter button
        }
    });
});


