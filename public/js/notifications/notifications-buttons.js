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


document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-notification-button').forEach(button => {
        button.addEventListener('click', function () {
            const notificationId = this.dataset.id;

            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to delete notification');
                }
                return response.json();
            })
            .then(data => {
                console.log(data.message);
                const notificationCard = this.closest('.notification');
                if (notificationCard) {
                    notificationCard.remove();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const notificationCards = document.querySelectorAll('.notification');

    notificationCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            const notificationId = this.dataset.id;

            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to mark notification as read');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data.message);

                    // Update the unread count globally
                    updateUnreadCount();

                    // Remove the green dot (unread indicator) for the current notification
                    const unreadIndicator = card.querySelector('.unread-notification-indicator');
                    if (unreadIndicator) {
                        unreadIndicator.remove();
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });

    function updateUnreadCount() {
        fetch('/notifications/unread-count', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch unread notifications count');
                }
                return response.json();
            })
            .then(data => {
                const countElement = document.getElementById('notification-count');
                if (countElement) {
                    if (data.unread_count > 0) {
                        countElement.textContent = data.unread_count;
                        countElement.style.display = 'inline-block';
                    } else {
                        countElement.textContent = '';
                        countElement.style.display = 'none';
                    }
                }
            })
            .catch(error => console.error('Error fetching unread notifications count:', error));
    }
});



