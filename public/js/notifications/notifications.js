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

function updateNotificationCount() {
    fetch('/notifications/unread-count', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            console.error('Failed to fetch unread notifications count.');
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data.unread_count !== undefined) {
            // Update the notification count in the UI
            const countElement = document.getElementById('notification-count');
            countElement.textContent = `(${data.unread_count})`;
        }
    })
    .catch(error => console.error('Error:', error));
}

setInterval(updateNotificationCount, 10000);

// Also fetch the count on page load
document.addEventListener('DOMContentLoaded', updateNotificationCount);
