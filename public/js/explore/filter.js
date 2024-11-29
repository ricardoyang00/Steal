document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.show-more').forEach(button => {
        button.addEventListener('click', function() {
            const targetClass = this.getAttribute('data-target');
            console.log(`Toggling visibility for elements with class: ${targetClass}`);
            document.querySelectorAll(`.${targetClass}`).forEach(element => {
                element.classList.toggle('d-none');
                console.log(`Toggled element:`, element);
            });
            this.textContent = this.textContent === 'Show More' ? 'Show Less' : 'Show More';
            console.log(`Button text changed to: ${this.textContent}`);
        });
    });
});