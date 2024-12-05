document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('confirmation-modal');
    var modalTitle = document.getElementById('modal-title');
    var modalMessage = document.getElementById('modal-message');
    var confirmBtn = document.getElementById('confirm-btn');
    var span = document.getElementsByClassName('close')[0];
    var cancelBtn = document.querySelector('.cancel-btn');
    var formId;

    function showModal(title, message, formIdToSubmit) {
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        formId = formIdToSubmit;
        modal.style.display = 'block';
    }

    document.querySelectorAll('.confirmation-btn').forEach(function(button) {
        button.onclick = function() {
            var title = this.getAttribute('data-title');
            var message = this.getAttribute('data-message');
            var formIdToSubmit = this.getAttribute('data-form-id');
            showModal(title, message, formIdToSubmit);
        }
    });

    confirmBtn.onclick = function() {
        document.getElementById(formId).submit();
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    cancelBtn.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});