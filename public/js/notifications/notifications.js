document.addEventListener('DOMContentLoaded', function () {
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
            const countElement = document.getElementById('notification-count');

            if (!countElement) {
                console.error('Notification count element not found!');
                return;
            }

            if (data.unread_count !== undefined) {
                if (data.unread_count > 0) {
                    countElement.textContent = data.unread_count;
                    countElement.style.display = 'inline-block'; // Show badge
                } else {
                    countElement.textContent = ''; // Clear text
                    countElement.style.display = 'none'; // Hide badge
                }
            }
        })
        .catch(error => console.error('Error fetching unread notifications count:', error));
    }

    // Poll the server every 10 seconds
    setInterval(updateNotificationCount, 10000); // 10 seconds
    updateNotificationCount(); // Fetch the count immediately on page load
});


