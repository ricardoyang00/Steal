document.addEventListener('DOMContentLoaded', function() {
    var userTypeSelect = document.getElementById('user_type');
    var buyerFields = document.getElementById('buyer_fields');
    var googleButton = document.querySelector('.google-button');

    function toggleFields() {
        if (userTypeSelect.value === 'buyer') {
            buyerFields.style.display = 'block';
            googleButton.style.display = 'inline-flex';
        } else {
            buyerFields.style.display = 'none';
            googleButton.style.display = 'none';
        }
    }

    userTypeSelect.addEventListener('change', toggleFields);

    // Initial toggle based on the selected value
    toggleFields();
});