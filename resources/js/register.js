document.addEventListener('DOMContentLoaded', function() {
    var userTypeSelect = document.getElementById('user_type');
    var buyerFields = document.getElementById('buyer_fields');

    function toggleBuyerFields() {
        if (userTypeSelect.value === 'buyer') {
            buyerFields.style.display = 'block';
        } else {
            buyerFields.style.display = 'none';
        }
    }

    userTypeSelect.addEventListener('change', toggleBuyerFields);

    // Initial toggle based on the selected value
    toggleBuyerFields();
});