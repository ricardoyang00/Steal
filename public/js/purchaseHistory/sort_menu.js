// public/js/purchaseHistory/sort_menu.js

document.addEventListener('DOMContentLoaded', function () {
    // Select the sort button by its ID
    const dropdownButton = document.getElementById('purchase-history-sort-dropdownButton');

    // Select the dropdown menu by its class
    const dropdownMenu = document.querySelector('.purchase-history-select-order-options');

    // Select the dropdown container to toggle the 'open' class for arrow rotation
    const dropdownContainer = document.querySelector('.purchase-history-dropdown');

    // Flag to track the dropdown state
    let isOpen = false;

    // Function to open the dropdown
    function openDropdown() {
        dropdownMenu.classList.add('show');          // Show the dropdown menu
        dropdownContainer.classList.add('open');      // Rotate the arrow
        isOpen = true;                                // Update the flag
    }

    // Function to close the dropdown
    function closeDropdown() {
        dropdownMenu.classList.remove('show');       // Hide the dropdown menu
        dropdownContainer.classList.remove('open');   // Reset the arrow rotation
        isOpen = false;                               // Update the flag
    }

    // Function to toggle the dropdown state
    function toggleDropdown() {
        if (isOpen) {
            closeDropdown();
        } else {
            openDropdown();
        }
    }

    // Event listener for the sort button click
    dropdownButton.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent the click from propagating to the window
        toggleDropdown();   // Toggle the dropdown
    });

    // Event listener for clicks on dropdown menu items
    dropdownMenu.addEventListener('click', function (e) {
        if (e.target.tagName === 'A') { // Ensure an <a> tag was clicked
            closeDropdown();            // Close the dropdown
        }
    });

    // Event listener for clicks outside the dropdown to close it
    window.addEventListener('click', function (e) {
        if (!dropdownContainer.contains(e.target)) { // If the click is outside the dropdown
            closeDropdown();                        // Close the dropdown
        }
    });

    // Optional: Close dropdown when pressing the Escape key
    window.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && isOpen) { // If Escape is pressed and dropdown is open
            closeDropdown();                 // Close the dropdown
        }
    });
});

