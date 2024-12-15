function toggleDropdown() {
    const menu = document.getElementById('purchase-history-select-order-options');
    const isVisible = menu.style.display === 'block';
    menu.style.display = isVisible ? 'none' : 'block';
}

window.addEventListener('click', function(e) {
    const dropdownButton = document.getElementById('purchase-history-sort-dropdownButton');
    const dropdownMenu = document.getElementById('purchase-history-select-order-options');
    if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
        dropdownMenu.style.display = 'none';
    }
});
