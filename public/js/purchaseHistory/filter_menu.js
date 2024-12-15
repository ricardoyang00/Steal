// public/js/purchaseHistory/filter_menu.js

document.addEventListener('DOMContentLoaded', function () {
    // Select the filter button by its ID
    const filterButton = document.getElementById('purchase-history-filter-dropdownButton');

    // Select the filter menu by its class
    const filterMenu = document.querySelector('.purchase-history-select-filter-options');

    // Select the filter container to toggle the 'open' class for arrow rotation
    const filterContainer = document.querySelector('.purchase-history-filter-dropdown');

    // Function to open the filter dropdown
    function openFilterDropdown() {
        filterMenu.classList.add('show');           // Show the filter menu
        filterContainer.classList.add('open');      // Rotate the arrow
    }

    // Function to close the filter dropdown
    function closeFilterDropdown() {
        filterMenu.classList.remove('show');        // Hide the filter menu
        filterContainer.classList.remove('open');    // Reset the arrow rotation
    }

    // Function to toggle the filter dropdown
    function toggleFilterDropdown() {
        if (filterMenu.classList.contains('show')) {
            closeFilterDropdown();
        } else {
            openFilterDropdown();
        }
    }

    // Event listener for the filter button click
    filterButton.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent the click from propagating to the window
        toggleFilterDropdown(); // Toggle the filter dropdown
    });

    // Event listener for clicks outside the filter dropdown to close it
    window.addEventListener('click', function (e) {
        if (!filterContainer.contains(e.target)) { // If the click is outside the filter dropdown
            closeFilterDropdown();                // Close the filter dropdown
        }
    });

    // Optional: Close filter dropdown when pressing the Escape key
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && filterMenu.classList.contains('show')) {
            closeFilterDropdown();
        }
    });
});

