document.addEventListener('DOMContentLoaded', function() {
    const preReleaseCheckbox = document.getElementById('pre_release');
    const releaseDateInput = document.querySelector('input[name="release_date"]');

    preReleaseCheckbox.addEventListener('change', function() {
        if (preReleaseCheckbox.checked) {
            releaseDateInput.value = '';
            releaseDateInput.disabled = true;
        } else {
            releaseDateInput.disabled = false;
        }
    });
});