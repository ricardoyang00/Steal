// public/js/purchaseHistory/cancel_pending_order_items.js

document.addEventListener('DOMContentLoaded', function () {
    console.log('Script loaded: Initializing modal functionality.');

    // Get modal elements
    var modal = document.getElementById('deletePrePurchaseModal');
    var closeModalBtn = document.getElementById('customModalClose');
    var deleteButton = document.getElementById('deleteButton');
    var deletePrePurchaseForm = document.getElementById('deletePrePurchaseForm');
    var deleteCountInput = document.getElementById('remove_order_count');
    var modalGameName = document.getElementById('modal-game-name');
    var modalGameImage = document.getElementById('modal-game-image');
    var modalPrePurchaseIdsContainer = document.getElementById('pre_purchase_ids_container');
    var decreaseOrderBtn = document.getElementById('decreaseOrder');
    var increaseOrderBtn = document.getElementById('increaseOrder');

    var lastFocusedElement;
    var currentMax = 1; // Initialize to 1
    var allPurchaseIds = []; // To store all purchase IDs for the modal

    // Function to open the modal and populate data
    function openModal(button) {
        console.log('openModal called for:', button);

        lastFocusedElement = button;

        var purchaseIdsString = button.getAttribute('data-purchase-ids') || '';
        allPurchaseIds = purchaseIdsString.split(',').map(function(id) { return id.trim(); }).filter(function(id) { return id !== ''; });

        var gameName = button.getAttribute('data-game') || '';
        var purchaseCount = parseInt(button.getAttribute('data-count')) || 1;
        var gameImage = button.getAttribute('data-game-image') || '';

        // Populate modal content
        if (modalGameName) {
            modalGameName.textContent = gameName;
        }

        if (modalGameImage) {
            modalGameImage.src = gameImage;
            modalGameImage.alt = gameName;
        }

        // Set the remove_order_count to purchaseCount or the number of available purchase IDs
        currentMax = Math.min(purchaseCount, allPurchaseIds.length);
        deleteCountInput.value = currentMax;

        // Populate the hidden inputs
        populateHiddenInputs(currentMax);

        // Show the modal
        modal.style.display = 'block';
        console.log('Modal displayed with', currentMax, 'pre-purchases.');

        // Set focus to the increase button for accessibility
        if (increaseOrderBtn) {
            increaseOrderBtn.focus();
        }
    }

    // Function to populate hidden inputs based on remove_order_count
    function populateHiddenInputs(count) {
        // Clear existing hidden inputs
        modalPrePurchaseIdsContainer.innerHTML = '';

        // Add hidden inputs for the first 'count' purchase IDs
        for (var i = 0; i < count; i++) {
            if (allPurchaseIds[i]) {
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'pre_purchase_ids[]';
                input.value = allPurchaseIds[i];
                modalPrePurchaseIdsContainer.appendChild(input);
            }
        }

        console.log('Hidden inputs populated with', count, 'purchase IDs.');
    }

    // Function to close the modal
    function closeModal() {
        console.log('closeModal called');
        modal.style.display = 'none';

        // Return focus to the last focused element
        if (lastFocusedElement) {
            lastFocusedElement.focus();
        }
    }

    // Attach event listeners to all "Cancel Item Orders" buttons
    var cancelOrderButtons = document.querySelectorAll('.delete-prepurchase-items-button');
    console.log('Found cancelOrderButtons:', cancelOrderButtons.length);
    cancelOrderButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            console.log('Cancel Item Orders button clicked:', button);
            openModal(button);
        });
    });

    // Attach event listener to close button
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    // Close modal when clicking outside the modal content
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Handle Escape key to close the modal
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.style.display === 'block') {
            closeModal();
        }
    });

    // Handle + button
    if (increaseOrderBtn && deleteCountInput) {
        increaseOrderBtn.addEventListener('click', function () {
            if (currentMax < allPurchaseIds.length) {
                currentMax += 1;
                deleteCountInput.value = currentMax;
                populateHiddenInputs(currentMax);
            } else {
                console.log('Maximum number of cancellations reached.');
            }
        });
    }

    // Handle - button
    if (decreaseOrderBtn && deleteCountInput) {
        decreaseOrderBtn.addEventListener('click', function () {
            if (currentMax > 1) {
                currentMax -= 1;
                deleteCountInput.value = currentMax;
                populateHiddenInputs(currentMax);
            } else {
                console.log('Minimum number of cancellations reached.');
            }
        });
    }

    // Disable submit button on form submission to prevent multiple submissions
    if (deletePrePurchaseForm && deleteButton) {
        deletePrePurchaseForm.addEventListener('submit', function () {
            deleteButton.disabled = true;
            deleteButton.textContent = 'Deleting...';
            console.log('Form submitted: Deleting pre-purchases.');
        });
    }

    console.log('Modal initialization complete.');
});


