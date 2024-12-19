// public/js/purchaseHistory/sort_menu.js

document.addEventListener('DOMContentLoaded', function () {
    // Select the sort button by its ID
    const sortButton = document.getElementById('purchase-history-sort-dropdownButton');

    // Select the sort container to toggle the 'active' class
    const sortContainer = document.querySelector('.purchase-history-dropdown');

    // Function to toggle the sort dropdown
    function toggleSortDropdown() {
        sortContainer.classList.toggle('active'); // Toggle the 'active' class
        const isActive = sortContainer.classList.contains('active');

        // Update ARIA attribute for accessibility
        sortButton.setAttribute('aria-expanded', isActive);
    }

    // Event listener for the sort button click
    sortButton.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent the click from propagating to the window
        toggleSortDropdown(); // Toggle the sort dropdown

        // Close the filter dropdown if it's open
        const filterContainer = document.querySelector('.purchase-history-filter-dropdown.active');
        if (filterContainer && filterContainer !== sortContainer) {
            filterContainer.classList.remove('active');
            const filterButton = filterContainer.querySelector('.purchase-history-filter-dropdownButton');
            if (filterButton) {
                filterButton.setAttribute('aria-expanded', false);
            }
        }
    });

    // Event listener for clicks on sort menu items
    const sortMenu = sortContainer.querySelector('.purchase-history-select-order-options');
    sortMenu.addEventListener('click', function (e) {
        if (e.target.tagName === 'A') { // Ensure an <a> tag was clicked
            sortContainer.classList.remove('active'); // Close the dropdown
            sortButton.setAttribute('aria-expanded', false);
        }
    });

    // Event listener for clicks outside the sort dropdown to close it
    window.addEventListener('click', function (e) {
        if (!sortContainer.contains(e.target) && !sortButton.contains(e.target)) {
            if (sortContainer.classList.contains('active')) {
                sortContainer.classList.remove('active');
                sortButton.setAttribute('aria-expanded', false);
            }
        }
    });

    // Optional: Close sort dropdown when pressing the Escape key
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && sortContainer.classList.contains('active')) {
            sortContainer.classList.remove('active');
            sortButton.setAttribute('aria-expanded', false);
            sortButton.focus(); // Return focus to the sort button
        }
    });
});


