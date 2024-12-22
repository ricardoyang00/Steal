document.addEventListener('DOMContentLoaded', function () {
    let previouslyOpen = new Set(); // To store IDs of open sections

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

    function reattachEventHandlers() {
        // View notification details toggling
        document.querySelectorAll('.view-notification-details').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.classList.toggle('show');
                    if (targetElement.classList.contains('show')) {
                        previouslyOpen.add(targetId);
                    } else {
                        previouslyOpen.delete(targetId);
                    }
                }
            });
        });

        // Delete notification buttons
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

        // Mark notification as read on hover
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

                        // Remove the green dot (unread indicator)
                        const unreadIndicator = card.querySelector('.unread-notification-indicator');
                        if (unreadIndicator) {
                            unreadIndicator.remove();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    }

    function updateNotificationsList(notifications) {
        const notificationsContainer = document.querySelector('.notifications');
        if (!notificationsContainer) return;

        // Store currently open sections before clearing
        previouslyOpen.clear();
        document.querySelectorAll('.notifications-collapse.show').forEach(openEl => {
            previouslyOpen.add('#' + openEl.id);
        });

        // Clear current notifications
        notificationsContainer.innerHTML = '';

        // If no notifications
        if (!notifications || notifications.length === 0) {
            notificationsContainer.innerHTML = '<div class="no-notifications">You have no notifications at the moment.</div>';
            return;
        }

        const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];

        notifications.forEach(notification => {
            const notificationDiv = document.createElement('div');
            notificationDiv.classList.add('notification');
            notificationDiv.dataset.id = notification.id;
            notificationDiv.dataset.type = notification.type;

            const cardDiv = document.createElement('div');
            cardDiv.classList.add('notification-card');

            const headerDiv = document.createElement('div');
            headerDiv.classList.add('notification-header');
            const titleH5 = document.createElement('h5');
            titleH5.classList.add('notification-title');
            let titleHTML = notification.title;

            switch(notification.type) {
                case 'Order':
                    titleHTML = `<a href="/user/order-history" class="notification-title-link">${notification.title}</a>`;
                    break;
                case 'ShoppingCart':
                    titleHTML = `<a href="/cart" class="notification-title-link">${notification.title}</a>`;
                    break;
                case 'Wishlist':
                    titleHTML = `<a href="/wishlist" class="notification-title-link">${notification.title}</a>`;
                    break;
                case 'Game':
                    titleHTML = `<a href="/seller/products" class="notification-title-link">${notification.title}</a>`;
                    break;
                case 'Review':
                    if (notification.parsedDetails && notification.parsedDetails.game_id) {
                        titleHTML = `<a href="/game/${notification.parsedDetails.game_id}" class="notification-title-link">${notification.title}</a>`;
                    } else {
                        // Fallback to plain text if game_id is missing
                        titleHTML = notification.title;
                    }
                    break;
                default:
                    titleHTML = notification.title;
            }

            titleH5.innerHTML = titleHTML;
            headerDiv.appendChild(titleH5);

            const deleteButton = document.createElement('button');
            deleteButton.classList.add('delete-notification-button');
            deleteButton.setAttribute('data-id', notification.id);
            deleteButton.setAttribute('aria-label', 'Delete notification');
            deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
            headerDiv.appendChild(deleteButton);

            cardDiv.appendChild(headerDiv);

            const bodyDiv = document.createElement('div');
            bodyDiv.classList.add('notification-body');
            const descP = document.createElement('p');
            descP.classList.add('notification-text');
            descP.textContent = notification.description;
            bodyDiv.appendChild(descP);

            const timeSmall = document.createElement('small');
            timeSmall.classList.add('notification-time');

            // Format time as "December 07 2024, 15:00"
            const dateObj = new Date(notification.time);
            const monthName = monthNames[dateObj.getMonth()];
            const day = String(dateObj.getDate()).padStart(2, '0');
            const year = dateObj.getFullYear();
            const hours = String(dateObj.getHours()).padStart(2, '0');
            const minutes = String(dateObj.getMinutes()).padStart(2, '0');
            const formattedTime = `${monthName} ${day} ${year}, ${hours}:${minutes}`;
            timeSmall.textContent = formattedTime;
            bodyDiv.appendChild(timeSmall);

            if (!notification.is_read) {
                const unreadSpan = document.createElement('span');
                unreadSpan.classList.add('unread-notification-indicator');
                bodyDiv.appendChild(unreadSpan);
            }

            
            
            const detailsButton = document.createElement('button');
            detailsButton.classList.add('view-notification-details');
            detailsButton.setAttribute('type', 'button');
            detailsButton.setAttribute('data-toggle', 'collapse');
            detailsButton.setAttribute('data-target', '#details-' + notification.id);
            detailsButton.setAttribute('aria-expanded', 'false');
            detailsButton.setAttribute('aria-controls', 'details-' + notification.id);
              

            // Set button text based on type
            if (['Wishlist', 'ShoppingCart'].includes(notification.type)) {
                if(notification.parsedDetails && notification.parsedDetails.specific_type == 'Price'){
                    detailsButton.textContent = 'View Details';
                }
            } else if (notification.type === 'Order Completed' || notification.type === 'Status Change') {
                detailsButton.textContent = 'View Details';
            } else if (notification.type === 'Game' || notification.type === 'Review') {
                detailsButton.textContent = 'View Details';
            }

            if(['Wishlist', 'ShoppingCart'].includes(notification.type)){
                if(notification.parsedDetails && notification.parsedDetails.specific_type == 'Price'){
                    bodyDiv.appendChild(detailsButton);
                }
            }
            else if(notification.type === 'Order Completed' || notification.type === 'Status Change' || notification.type === 'Game' || notification.type === 'Review'){
                bodyDiv.appendChild(detailsButton);
            }
            cardDiv.appendChild(bodyDiv);
            
            const collapseDiv = document.createElement('div');
            collapseDiv.classList.add('notifications-collapse', 'collapse');
            collapseDiv.id = 'details-' + notification.id;
            const detailsContentDiv = document.createElement('div');
            detailsContentDiv.classList.add('notification-details');
            

            // Populate details based on notification.type
            if ((notification.type === 'Order Completed' || notification.type == 'Status Change') && notification.orderDetails) {
                const dateP = document.createElement('p');
                dateP.innerHTML = `<strong>Placed at:</strong> ${notification.orderDetails.date}`;
                detailsContentDiv.appendChild(dateP);
                const purchasesObj = notification.orderDetails?.purchases || {};
                const purchases = Array.isArray(purchasesObj) ? purchasesObj : Object.values(purchasesObj);
                console.log('Notification orderDetails:', notification.orderDetails);
                const deliveredGames = purchases.filter(p => p.type === 'Delivered');
                const canceledGames = purchases.filter(p => p.type === 'Canceled');
                const prePurchasedGames = purchases.filter( p => p.type === 'Ordered');

                if (prePurchasedGames.length > 0) {
                    const purchasedTitle = document.createElement('h6');
                    purchasedTitle.textContent = 'Ordered Games:';
                    detailsContentDiv.appendChild(purchasedTitle);

                    const ulprePurchased = document.createElement('ul');
                    prePurchasedGames.forEach(p => {
                        const li = document.createElement('li');
                        if (p.gameId) {
                            let gamePrice = Number(p.value);
                            li.innerHTML = `<a href="/game/${p.gameId}">${p.gameName}</a> - €${gamePrice.toFixed(2)}`;
                        } else {
                            li.textContent = `${p.gameName} - €${p.value}`;
                        }
                        ulprePurchased.appendChild(li);
                    });
                    detailsContentDiv.appendChild(ulprePurchased);
                }

                if (deliveredGames.length > 0) {
                    const purchasedTitle = document.createElement('h6');
                    purchasedTitle.textContent = 'Delivered Games:';
                    detailsContentDiv.appendChild(purchasedTitle);

                    const ulPurchased = document.createElement('ul');
                    deliveredGames.forEach(p => {
                        const li = document.createElement('li');
                        if (p.gameId) {
                            let gamePrice = Number(p.value); 
                            li.innerHTML = `<a href="/game/${p.gameId}">${p.gameName}</a> - €${gamePrice.toFixed(2)}`;
                        } else {
                            li.textContent = `${p.gameName} - €${p.value}`;
                        }
                        ulPurchased.appendChild(li);
                    });
                    detailsContentDiv.appendChild(ulPurchased);
                }

                if (canceledGames.length > 0) {
                    const canceledTitle = document.createElement('h6');
                    canceledTitle.textContent = 'Canceled Purchases:';
                    detailsContentDiv.appendChild(canceledTitle);

                    const ulCanceled = document.createElement('ul');
                    canceledGames.forEach(p => {
                        const li = document.createElement('li');
                        if (p.gameId) {
                            let gamePrice = Number(p.value); 
                            li.innerHTML = `<a href="/game/${p.gameId}">${p.gameName}</a> - €${gamePrice.toFixed(2)}`;
                        } else {
                            li.textContent = `${p.gameName} - €${p.value}`;
                        }
                        ulCanceled.appendChild(li);
                    });
                    detailsContentDiv.appendChild(ulCanceled);
                }

                const usedCoinsP = document.createElement('p');
                const totalPriceP = document.createElement('p');
                usedCoinsP.innerHTML = `<strong>Coins Used:</strong> ${notification.orderDetails.coinsUsed ?? 0.0} S-Coins`;
                totalPriceP.innerHTML = `<strong>Total Price:</strong> €${notification.orderDetails.totalPrice ?? 0.0}`;
                detailsContentDiv.appendChild(usedCoinsP);
                detailsContentDiv.appendChild(totalPriceP);

            } else if ((notification.type === 'Wishlist' || notification.type === 'ShoppingCart') && notification.parsedDetails) {
                const gameNameP = document.createElement('p');
                if (notification.parsedDetails.game_id) {
                    gameNameP.innerHTML = `<strong>Game:</strong> <a href="/game/${notification.parsedDetails.game_id}">${notification.parsedDetails.game_name ?? 'Unknown Game'}</a>`;
                } else {
                    gameNameP.innerHTML = `<strong>Game:</strong> ${notification.parsedDetails.game_name ?? 'Unknown Game'}`;
                }
                detailsContentDiv.appendChild(gameNameP);

                if (notification.parsedDetails.specific_type === 'Price') {
                    const oldPriceP = document.createElement('p');
                    oldPriceP.innerHTML = `<strong>Old Price:</strong> €${notification.parsedDetails.old_price ?? 'N/A'}`;
                    detailsContentDiv.appendChild(oldPriceP);

                    const newPriceP = document.createElement('p');
                    newPriceP.innerHTML = `<strong>New Price:</strong> €${notification.parsedDetails.new_price ?? 'N/A'}`;
                    detailsContentDiv.appendChild(newPriceP);
                }

            } else if (notification.type === 'Game' && notification.parsedDetails) {
                const gameNameP = document.createElement('p');
                if (notification.gameId) {
                    gameNameP.innerHTML = `<strong>Game:</strong> <a href="/game/${notification.gameId}">${notification.parsedDetails.game_name ?? 'Unknown Game'}</a>`;
                } else {
                    gameNameP.innerHTML = `<strong>Game:</strong> ${notification.parsedDetails.game_name ?? 'Unknown Game'}`;
                }
                detailsContentDiv.appendChild(gameNameP);

                const quantity = notification.parsedDetails.quantity ?? 0;
                let totalPrice = notification.parsedDetails.total_price ?? 0.0;
                totalPrice = parseFloat(totalPrice) || 0.0;
                const unitPrice = quantity > 0 ? (totalPrice / quantity) : 0.0;

                const quantityP = document.createElement('p');
                quantityP.innerHTML = `<strong>Quantity:</strong> ${quantity}`;
                detailsContentDiv.appendChild(quantityP);

                const gamePriceP = document.createElement('p');
                gamePriceP.innerHTML = `<strong>Unit Price:</strong> €${unitPrice.toFixed(2)}`;
                detailsContentDiv.appendChild(gamePriceP);

                const totalPriceP = document.createElement('p');
                totalPriceP.innerHTML = `<strong>Total Price:</strong> €${totalPrice.toFixed(2)}`;
                detailsContentDiv.appendChild(totalPriceP);
            } else if (notification.type === 'Review' && notification.parsedDetails) {
                const gameNameP = document.createElement('p');
                if (notification.parsedDetails.game_id) {
                    gameNameP.innerHTML = `<strong>Game:</strong> <a href="/game/${notification.parsedDetails.game_id}">${notification.parsedDetails.game_name ?? 'Unknown Game'}</a>`;
                } else {
                    gameNameP.innerHTML = `<strong>Game:</strong> ${notification.parsedDetails.game_name ?? 'Unknown Game'}`;
                }
                detailsContentDiv.appendChild(gameNameP);

                const authorP = document.createElement('p');
                authorP.innerHTML = `<strong>Author:</strong> ${notification.parsedDetails.review_author ?? 'Unknown Author'}`;
                detailsContentDiv.appendChild(authorP);

                const reviewTypeP = document.createElement('p');
                reviewTypeP.innerHTML = `<strong>Rating:</strong> ${notification.parsedDetails.review_type ?? 'Unknown'}`;
                detailsContentDiv.appendChild(reviewTypeP);
            }

            collapseDiv.appendChild(detailsContentDiv);
            cardDiv.appendChild(collapseDiv);

            notificationDiv.appendChild(cardDiv);
            notificationsContainer.appendChild(notificationDiv);
        });

        // Reattach event handlers after rebuilding the notifications
        reattachEventHandlers();

        // Re-open previously opened sections if they still exist
        previouslyOpen.forEach(selector => {
            const el = document.querySelector(selector);
            if (el) {
                el.classList.add('show');
            }
        });
    }

    function fetchNewNotifications() {
        fetch('/notifications/fetchNotifications', {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to fetch new notifications');
            }
            return response.json();
        })
        .then(data => {
            updateNotificationsList(data.notifications);
        })
        .catch(error => console.error('Error fetching new notifications:', error));
    }

    // Fetch and update notifications every 10 seconds
    setInterval(fetchNewNotifications, 10000);

    // Initially attach event handlers for currently rendered notifications
    reattachEventHandlers();
});






