document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-button');
    const cancelButtons = document.querySelectorAll('.cancel-button');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const li = this.closest('li');
            li.classList.add('editing');
            li.querySelector('.field-name').style.display = 'none';
            li.querySelector('.edit-form').style.display = 'flex';
            li.querySelector('.action-buttons').style.display = 'none';
        });
    });

    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const li = this.closest('li');
            li.classList.remove('editing');
            li.querySelector('.field-name').style.display = 'inline';
            li.querySelector('.edit-form').style.display = 'none';
            li.querySelector('.action-buttons').style.display = 'flex';
        });
    });
});