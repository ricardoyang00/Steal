function clearErrors() {
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(element => {
        element.innerHTML = '';
    });
}

document.getElementById('edit-profile-btn').addEventListener('click', function() {
    document.getElementById('profile').style.display = 'none';
    document.getElementById('edit-profile').style.display = 'flex';
});

document.getElementById('cancel-edit-btn').addEventListener('click', function() {
    clearErrors();
    document.getElementById('edit-profile').style.display = 'none';
    document.getElementById('profile').style.display = 'flex';
});

document.getElementById('change-password-btn').addEventListener('click', function() {
    document.getElementById('profile').style.display = 'none';
    document.getElementById('change-password').style.display = 'block';
});

document.getElementById('cancel-change-password-btn').addEventListener('click', function() {
    clearErrors();
    document.getElementById('change-password').style.display = 'none';
    document.getElementById('profile').style.display = 'flex';
});

document.addEventListener('DOMContentLoaded', function() {
    const profilePictureInput = document.getElementById('profile_picture');
    const profilePictureImg = document.getElementById('editable-profile-picture');
    const originalProfilePictureSrc = profilePictureImg.src;
    const editIcon = document.getElementById('edit-icon');
    const cancelEditBtn = document.getElementById('cancel-edit-btn');

    editIcon.addEventListener('click', function() {
        profilePictureInput.click();
    });

    profilePictureInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePictureImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    cancelEditBtn.addEventListener('click', function() {
        profilePictureImg.src = originalProfilePictureSrc;
        profilePictureInput.value = ''; // Clear the file input
    });


    const togglePasswordIcons = document.querySelectorAll('.toggle-password');

    togglePasswordIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('data-toggle'));
            if (input.getAttribute('type') === 'password') {
                input.setAttribute('type', 'text');
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            } else {
                input.setAttribute('type', 'password');
                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }
        });
    });

    var modal = document.getElementById('confirmation-modal');
    var btn = document.getElementById('delete-account-btn');
    var span = document.getElementsByClassName('close')[0];
    var cancelBtn = document.querySelector('.cancel-btn');

    btn.onclick = function() {
        modal.style.display = 'block';
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