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
});
