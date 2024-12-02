document.addEventListener('DOMContentLoaded', function() {
    // checkboxes ajax
    document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            document.getElementById('filter-form').submit();
        });
    });

    // clear filters
    document.getElementById('clear-filters').addEventListener('click', function() {
        const form = document.getElementById('filter-form');
        form.reset();
        document.querySelectorAll('.form-check-input').forEach(function(checkbox) {
            checkbox.checked = false;
        });
        form.submit();
    });
});