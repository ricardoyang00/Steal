document.getElementById('notifications-tab').addEventListener('click', function () {
    fetch('/notifications/mark-as-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            console.error('Failed to mark notifications as read.');
        } else {
            console.log('Notifications marked as read.');
        }
    })
    .catch(error => console.error('Error:', error));
});