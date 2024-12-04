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
            const id = this.getAttribute('data-id');

            fetch(`/notifications/${id}/mark-as-read`, {
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
                    const unreadIndicator = this.querySelector('.unread-notification-indicator');
                    if (unreadIndicator) {
                        unreadIndicator.remove();
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});

