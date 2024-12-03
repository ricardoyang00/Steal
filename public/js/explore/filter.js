document.addEventListener('DOMContentLoaded', function () {
    // AJAX Filter checkboxes AJAX
    document.querySelectorAll('.form-check-input').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            document.getElementById('filter-form').submit();
        });
    });

    // Clear Filters
    document.getElementById('clear-filters').addEventListener('click', function () {
        const form = document.getElementById('filter-form');
        const url = new URL(form.action, window.location.origin);

        // maintain query and sort parameters
        const query = form.querySelector('input[name="query"]')?.value || '';
        const sort = form.querySelector('input[name="sort"]')?.value || '';
        if (query) url.searchParams.set('query', query);
        if (sort) url.searchParams.set('sort', sort);

        window.location.href = url.toString();
    });

    const seeMoreBtn = document.getElementById('see-more-btn');
    if (seeMoreBtn) {
        seeMoreBtn.addEventListener('click', function() {
            const hiddenCategories = document.querySelectorAll('.hidden-category');
            hiddenCategories.forEach(function(category) {
                category.style.display = 'block';
            });
            seeMoreBtn.style.display = 'none'; // Hide the "See More" button after clicking
        });
    }

    var collapsibles = document.querySelectorAll('.collapsible');
    collapsibles.forEach(function(collapsible, index) {
        // Restore the state from local storage
        var content = collapsible.nextElementSibling;
        var state = localStorage.getItem('collapsible-' + index);
        if (state === 'open') {
            content.style.display = 'block';
            collapsible.classList.add('active');
        }

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
});
