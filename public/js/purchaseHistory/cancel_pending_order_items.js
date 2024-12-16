// public/js/purchaseHistory/cancel_pending_order_items.js

document.addEventListener('DOMContentLoaded', function () {
    console.log('Script loaded: Attempting to initialize modal functionality.');

    // Get modal elements
    var modal = document.getElementById('deletePrePurchaseModal');
    var closeModalBtn = document.getElementById('customModalClose');
    var deleteButton = document.getElementById('deleteButton');
    var deletePrePurchaseForm = document.getElementById('deletePrePurchaseForm');
    var deleteCountInput = document.getElementById('remove_order_count');
    var modalGameName = document.getElementById('modal-game-name');
    var modalGameImage = document.getElementById('modal-game-image');
    var modalPrePurchaseIds = document.getElementById('pre_purchase_ids');
    var decreaseOrderBtn = document.getElementById('decreaseOrder');
    var increaseOrderBtn = document.getElementById('increaseOrder');

    var lastFocusedElement;
    var currentMax = 1; // Initialize to 1

    // Function to open the modal and populate data
    function openModal(button) {
        console.log('openModal called for:', button);
        lastFocusedElement = button;

        var purchaseIds = button.getAttribute('data-purchase-ids') ? button.getAttribute('data-purchase-ids').split(',') : [];
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

        if (modalPrePurchaseIds) {
            modalPrePurchaseIds.value = purchaseIds.join(',');
        }

        // Set the remove_order_count to purchaseCount
        if (deleteCountInput) {
            deleteCountInput.value = purchaseCount;
            currentMax = purchaseCount;
            deleteCountInput.setAttribute('data-max', purchaseCount);
        }

        // Show the modal
        modal.style.display = 'block';
        console.log('Modal displayed');

        // Set focus to the increase button for accessibility
        if (increaseOrderBtn) {
            increaseOrderBtn.focus();
        }
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
            var currentValue = parseInt(deleteCountInput.value) || 1;
            var max = parseInt(deleteCountInput.getAttribute('data-max')) || 1;
            if (currentValue < max) {
                deleteCountInput.value = currentValue + 1;
            }
        });
    }

    // Handle - button
    if (decreaseOrderBtn && deleteCountInput) {
        decreaseOrderBtn.addEventListener('click', function () {
            var currentValue = parseInt(deleteCountInput.value) || 1;
            if (currentValue > 1) {
                deleteCountInput.value = currentValue - 1;
            }
        });
    }

    // Disable submit button on form submission to prevent multiple submissions
    if (deletePrePurchaseForm && deleteButton) {
        deletePrePurchaseForm.addEventListener('submit', function () {
            deleteButton.disabled = true;
            deleteButton.textContent = 'Deleting...';
        });
    }

    console.log('Modal initialization complete');
});


