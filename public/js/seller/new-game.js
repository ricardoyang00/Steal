document.addEventListener('DOMContentLoaded', function() {
    const preReleaseCheckbox = document.getElementById('pre_release');
    const releaseDateInput = document.querySelector('input[name="release_date"]');
    const maxFileSize = 2 * 1024 * 1024; // 2MB

    preReleaseCheckbox.addEventListener('change', function() {
        if (preReleaseCheckbox.checked) {
            releaseDateInput.value = '';
            releaseDateInput.disabled = true;
        } else {
            releaseDateInput.disabled = false;
        }
    });

    // Image preview
    function readURL(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function handleFileChange(input, previewId) {
        if (input.files && input.files[0]) {
            if (input.files[0].size > maxFileSize) {
                alert('File size exceeds 2MB limit.');
                input.value = ''; // Clear the input
                return;
            }
            readURL(input, previewId);
        }
    }

    document.querySelector('input[name="thumbnail_small_path"]').addEventListener('change', function() {
        handleFileChange(this, 'thumbnail_small_preview');
    });

    document.querySelector('input[name="thumbnail_large_path"]').addEventListener('change', function() {
        handleFileChange(this, 'thumbnail_large_preview');
    });

    document.querySelector('input[name="additional_images[]"]').addEventListener('change', function() {
        const previewContainer = document.getElementById('additional_images_preview');
        previewContainer.innerHTML = '';
        Array.from(this.files).forEach((file, index) => {
            if (file.size > maxFileSize) {
                alert('File size exceeds 2MB limit.');
                this.value = ''; // Clear the input
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '320px';
                img.style.height = '180px';
                img.style.margin = '5px';
                img.style.objectFit = 'cover';
                img.style.objectPosition = 'top';
                img.dataset.order = index;
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    // Client-side validation for file size
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            for (let i = 0; i < this.files.length; i++) {
                if (this.files[i].size > maxFileSize) {
                    alert('File size exceeds 2MB limit.');
                    this.value = ''; // Clear the input
                    break;
                }
            }
        });
    });
});