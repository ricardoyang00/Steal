document.addEventListener('DOMContentLoaded', function () {
    // Restore collapsible states before adding any listeners
    var collapsibles = document.querySelectorAll('.collapsible');
    collapsibles.forEach(function(collapsible, index) {
        var content = collapsible.nextElementSibling;
        var state = localStorage.getItem('collapsible-' + index);
        if (state === 'open') {
            content.style.display = 'block';
            collapsible.classList.add('active');
        }
    });

    // AJAX Filter checkboxes
    document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const form = document.getElementById('filter-form');
            const formData = new FormData(form);
            const url = new URL(form.action, window.location.origin);
            formData.forEach((value, key) => url.searchParams.append(key, value));
            
            // Use Fetch API for AJAX request
            fetch(url, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
                .then(response => response.text())
                .then(html => {
                    document.querySelector('.game-cards').innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
        });
    });

    // Clear Filters
    document.getElementById('clear-filters').addEventListener('click', function () {
        const form = document.getElementById('filter-form');
        const url = new URL(form.action, window.location.origin);

        // Maintain query and sort parameters
        const query = form.querySelector('input[name="query"]')?.value || '';
        const sort = form.querySelector('input[name="sort"]')?.value || '';
        if (query) url.searchParams.set('query', query);
        if (sort) url.searchParams.set('sort', sort);

        window.location.href = url.toString();
    });

    // Collapsible toggle functionality
    collapsibles.forEach(function(collapsible, index) {
        var content = collapsible.nextElementSibling;
        collapsible.addEventListener('click', function() {
            this.classList.toggle('active');
            if (content.style.display === "block") {
                content.style.display = "none";
                localStorage.setItem('collapsible-' + index, 'closed');
            } else {
                content.style.display = "block";
                localStorage.setItem('collapsible-' + index, 'open');
            }
        });
    });

    // "See More" and "Show Less" buttons
    function handleSeeMore(section) {
        const seeMoreBtn = document.getElementById(`see-more-btn-${section}`);
        if (seeMoreBtn) {
            seeMoreBtn.addEventListener('click', function () {
                const hiddenItems = document.querySelectorAll(`.${section} .hidden-category`);
                hiddenItems.forEach(function (item) {
                    item.style.display = 'block';
                });
                seeMoreBtn.style.display = 'none'; // Hide the "See More" button after clicking

                // Create and insert the "Show Less" button
                const showLessBtn = document.createElement('button');
                showLessBtn.type = 'button';
                showLessBtn.id = `show-less-btn-${section}`;
                showLessBtn.className = 'btn btn-link';
                showLessBtn.textContent = 'See Less';
                seeMoreBtn.parentNode.appendChild(showLessBtn);

                // Add event listener to the "Show Less" button
                showLessBtn.addEventListener('click', function () {
                    hiddenItems.forEach(function (item) {
                        item.style.display = 'none';
                    });
                    seeMoreBtn.style.display = 'block'; // Show the "See More" button again
                    showLessBtn.remove(); // Remove the "Show Less" button
                });
            });
        }
    }

    handleSeeMore('category');
    handleSeeMore('platform');
    handleSeeMore('language');
});