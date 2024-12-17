function clearErrors() {
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(element => {
        element.innerHTML = '';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const editProfileBtn = document.getElementById('edit-profile-btn');
    const cancelEditBtn = document.getElementById('cancel-edit-btn');
    const changePasswordBtn = document.getElementById('change-password-btn');
    const cancelChangePasswordBtn = document.getElementById('cancel-change-password-btn');
    const profilePictureInput = document.getElementById('profile_picture');
    const profilePictureImg = document.getElementById('editable-profile-picture');
    const editIcon = document.getElementById('edit-icon');

    if (editProfileBtn) {
        editProfileBtn.addEventListener('click', function() {
            document.getElementById('profile').style.display = 'none';
            document.getElementById('edit-profile').style.display = 'flex';
        });
    }

    if (cancelEditBtn) {
        cancelEditBtn.addEventListener('click', function() {
            clearErrors();
            document.getElementById('edit-profile').style.display = 'none';
            document.getElementById('profile').style.display = 'flex';
        });
    }

    if (changePasswordBtn) {
        changePasswordBtn.addEventListener('click', function() {
            document.getElementById('profile').style.display = 'none';
            document.getElementById('change-password').style.display = 'block';
        });
    }

    if (cancelChangePasswordBtn) {
        cancelChangePasswordBtn.addEventListener('click', function() {
            clearErrors();
            document.getElementById('change-password').style.display = 'none';
            document.getElementById('profile').style.display = 'flex';
        });
    }

    if (profilePictureInput && profilePictureImg && editIcon) {
        const originalProfilePictureSrc = profilePictureImg.src;

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

        if (cancelEditBtn) {
            cancelEditBtn.addEventListener('click', function() {
                profilePictureImg.src = originalProfilePictureSrc;
                profilePictureInput.value = ''; // Clear the file input
            });
        }
    }
});