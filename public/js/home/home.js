document.addEventListener("DOMContentLoaded", () => {
    const carousels = {};

    // Initialize carousel positions
    document.querySelectorAll(".carousel-track").forEach((track) => {
        const id = track.id;
        carousels[id] = {
            index: 0,
            items: track.children.length,
            track: track,
            cardWidth: track.children[0].getBoundingClientRect().width,
            gap: 20, // Same as CSS gap
        };
    });

    // Function to move the carousel
    window.moveCarousel = (carouselId, direction) => {
        const carousel = carousels[carouselId];
        if (!carousel) return;

        // Update index based on direction (left or right)
        carousel.index += direction;
        if (carousel.index < 0) {
            carousel.index = carousel.items - 1; // Loop to the last card
        } else if (carousel.index >= carousel.items) {
            carousel.index = 0; // Loop back to the first card
        }

        // Update transform to center the active card
        const offset =
            -(carousel.index * (carousel.cardWidth + carousel.gap)) +
            (window.innerWidth / 2 - carousel.cardWidth / 2) - carousel.gap / 2; // Adjust for gap

        // Apply the calculated offset to the carousel track
        carousel.track.style.transform = `translateX(${offset}px)`;
    };
});