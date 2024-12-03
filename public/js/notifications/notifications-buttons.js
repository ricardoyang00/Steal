document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.view-notification-details').forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetElement = document.querySelector(targetId);

            if (targetElement) {
                targetElement.classList.toggle('show');
            }
        });
    });
});
