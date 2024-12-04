function scrollToSection(event, sectionId) {
    event.preventDefault();
    document.getElementById(sectionId).scrollIntoView({
        behavior: 'smooth'
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var successNotification = document.querySelector('.alert-success.notification-popup');
    var errorNotification = document.querySelector('.alert-error.notification-popup');

    if (successNotification) {
        successNotification.style.display = 'block';
        setTimeout(function() {
            successNotification.style.display = 'none';
        }, 5000); // Hide after 5 seconds
    }

    if (errorNotification) {
        errorNotification.style.display = 'block';
        setTimeout(function() {
            errorNotification.style.display = 'none';
        }, 5000); // Hide after 5 seconds
    }
});
