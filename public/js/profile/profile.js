function clearErrors() {
    const errorElements = document.querySelectorAll('.error');
    errorElements.forEach(element => {
        element.innerHTML = '';
    });
}

document.getElementById('edit-profile-btn').addEventListener('click', function() {
    document.getElementById('profile').style.display = 'none';
    document.getElementById('edit-profile').style.display = 'block';
});

document.getElementById('cancel-edit-btn').addEventListener('click', function() {
    clearErrors();
    document.getElementById('edit-profile').style.display = 'none';
    document.getElementById('profile').style.display = 'block';
});

document.getElementById('change-password-btn').addEventListener('click', function() {
    document.getElementById('profile').style.display = 'none';
    document.getElementById('change-password').style.display = 'block';
});

document.getElementById('cancel-change-password-btn').addEventListener('click', function() {
    clearErrors();
    document.getElementById('change-password').style.display = 'none';
    document.getElementById('profile').style.display = 'block';
});