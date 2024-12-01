let currentIndex = 0;

function moveCarousel(trackId, direction) {
    const track = document.getElementById(trackId);
    const items = track.children;
    const itemsToShow = 5;
    const totalItems = items.length;

    currentIndex += direction * itemsToShow;

    if (currentIndex < 0) {
        currentIndex = totalItems - itemsToShow; // Loop back to the last set
    } else if (currentIndex >= totalItems) {
        currentIndex = 0; // Loop back to the first set
    }

    const offset = currentIndex * (100 / itemsToShow);
    track.style.transform = `translateX(-${offset}%)`;
}