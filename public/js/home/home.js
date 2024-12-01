document.addEventListener('DOMContentLoaded', function() {
    window.loadChunk = function(chunkIndex) {
        const container = document.getElementById('top-sellers-container');
        
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
                })
                .catch(error => console.error('Error loading chunk:', error));
        });
    };
});