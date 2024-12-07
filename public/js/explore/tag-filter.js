document.addEventListener('DOMContentLoaded', function() {
    window.filterByCategory = function(categoryId) {
        const form = document.getElementById('filter-form');

        // Remove existing category, player, and platform inputs
        const existingCategoryInputs = form.querySelectorAll('input[name="categories[]"]');
        existingCategoryInputs.forEach(input => input.remove());
        const existingPlayerInputs = form.querySelectorAll('input[name="players[]"]');
        existingPlayerInputs.forEach(input => input.remove());
        const existingPlatformInputs = form.querySelectorAll('input[name="platforms[]"]');
        existingPlatformInputs.forEach(input => input.remove());

        // Add the new category input
        const categoryInput = document.createElement('input');
        categoryInput.type = 'hidden';
        categoryInput.name = 'categories[]';
        categoryInput.value = categoryId;
        form.appendChild(categoryInput);

        form.submit();
    };

    window.filterByPlayer = function(playerId) {
        const form = document.getElementById('filter-form');

        // Remove existing category, player, and platform inputs
        const existingCategoryInputs = form.querySelectorAll('input[name="categories[]"]');
        existingCategoryInputs.forEach(input => input.remove());
        const existingPlayerInputs = form.querySelectorAll('input[name="players[]"]');
        existingPlayerInputs.forEach(input => input.remove());
        const existingPlatformInputs = form.querySelectorAll('input[name="platforms[]"]');
        existingPlatformInputs.forEach(input => input.remove());

        // Add the new player input
        const playerInput = document.createElement('input');
        playerInput.type = 'hidden';
        playerInput.name = 'players[]';
        playerInput.value = playerId;
        form.appendChild(playerInput);

        form.submit();
    };
});