document.addEventListener('DOMContentLoaded', function() {
    const statusInfo = document.getElementById('status-info');
    const statusText = statusInfo.textContent.trim();

    if (statusText === 'Disabled') {
        statusInfo.style.backgroundColor = '#dc3545'; // Red for Disabled
    } else if (statusText === 'Blocked') {
        statusInfo.style.backgroundColor = '#ffc107'; // Yellow for Blocked
    } else if (statusText === 'Active') {
        statusInfo.style.backgroundColor = '#28a745'; // Green for Active
    }

    const editCoinsBtn = document.getElementById('edit-coins-btn');
    const changeCoinsForm = document.getElementById('change-coins-form');
    const coinsDisplay = document.getElementById('coins-display');
    const cancelCoinsBtn = document.getElementById('cancel-change-coins-btn');
    const coinsInput = changeCoinsForm.querySelector('input[name="coins"]');
    const originalCoinsValue = coinsInput.value; // Store the original value

    editCoinsBtn.addEventListener('click', function() {
        coinsDisplay.style.display = 'none';
        changeCoinsForm.style.display = 'flex';
        editCoinsBtn.style.display = 'none';
    });

    cancelCoinsBtn.addEventListener('click', function() {
        coinsDisplay.style.display = 'inline';
        changeCoinsForm.style.display = 'none';
        editCoinsBtn.style.display = 'inline';
        coinsInput.value = originalCoinsValue; // Reset to the original value
    });
});