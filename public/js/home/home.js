document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('top-sellers-container');
    const paginationControls = document.querySelector('.pagination-controls');
    const totalChunks = parseInt(paginationControls.getAttribute('data-total-chunks'), 10);
    let currentChunkIndex = 0;
    let intervalId;
    
    // Add fade-in class to start the fade-in effect on initial load
    container.classList.add('fade-in');

    // Wait for the fade-in transition to complete
    container.addEventListener('transitionend', function handleInitialFadeIn() {
        container.removeEventListener('transitionend', handleInitialFadeIn);
        container.classList.remove('fade-in');
    });

    // Highlight the first pagination button on initial load
    const firstButton = document.querySelector('.pagination-btn');
    if (firstButton) {
        firstButton.classList.add('active');
    }

    window.loadChunk = function(chunkIndex) {
        const buttons = document.querySelectorAll('.pagination-btn');

        // Check if the clicked button is already active
        if (buttons[chunkIndex].classList.contains('active')) {
            return;
        }

        // Add fade-out class to start the fade-out effect
        container.classList.add('fade-out');

        // Wait for the fade-out transition to complete
        container.addEventListener('transitionend', function handleFadeOut() {
            container.removeEventListener('transitionend', handleFadeOut);

            const url = `/top-sellers-chunk/${chunkIndex}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(html => {
                    container.innerHTML = html;

                    // Add fade-in class to start the fade-in effect
                    container.classList.remove('fade-out');
                    container.classList.add('fade-in');

                    // Wait for the fade-in transition to complete
                    container.addEventListener('transitionend', function handleFadeIn() {
                        container.removeEventListener('transitionend', handleFadeIn);
                        container.classList.remove('fade-in');
                    });

                    // Update active class on pagination buttons
                    buttons.forEach(button => button.classList.remove('active'));
                    buttons[chunkIndex].classList.add('active');
                })
                .catch(error => console.error('Error loading chunk:', error));
        });
    };

    // Function to automatically change pages
    function autoChangePage() {
        currentChunkIndex = (currentChunkIndex + 1) % totalChunks;
        loadChunk(currentChunkIndex);
    }

    // Function to start the interval
    function startInterval() {
        if (!intervalId) {
            intervalId = setInterval(autoChangePage, 5000);
        }
    }

    // Function to stop the interval
    function stopInterval() {
        if (intervalId) {
            clearInterval(intervalId);
            intervalId = null;
        }
    }

    // Handle page visibility change
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopInterval();
        } else {
            startInterval();
        }
    });

    // Start the interval initially
    startInterval();
});