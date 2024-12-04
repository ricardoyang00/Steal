document.addEventListener('DOMContentLoaded', function () {
    let notificationInterval = null;

    function updateNotificationCount() {
        fetch('/notifications/unread-count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.status === 401) {
                clearInterval(notificationInterval);
                console.warn('Session expired. Polling stopped.');
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data?.unread_count !== undefined) {
                const countElement = document.getElementById('notification-count');
                if (countElement) {
                    countElement.textContent = data.unread_count > 0 ? data.unread_count : '';
                    countElement.style.display = data.unread_count > 0 ? 'inline-block' : 'none';
                }
            }
        })
        .catch(error => console.error('Error fetching unread notifications:', error));
    }

    updateNotificationCount();
    notificationInterval = setInterval(updateNotificationCount, 10000);
});



