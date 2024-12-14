document.addEventListener('DOMContentLoaded', function() {
    const maxFileSize = 2 * 1024 * 1024; // 2MB

    function handleFileChange(input, previewId) {
        const [file] = input.files;
        if (file) {
            if (file.size > maxFileSize) {
                alert('File size exceeds 2MB limit.');
                input.value = ''; // Clear the input
                return;
            }
            document.getElementById(previewId).src = URL.createObjectURL(file);
            document.getElementById(previewId).style.display = 'block';
        }
    }

    document.getElementById('thumbnail_large_path').addEventListener('change', function(event) {
        handleFileChange(event.target, 'thumbnail_large_preview');
    });

    document.getElementById('thumbnail_small_path').addEventListener('change', function(event) {
        handleFileChange(event.target, 'thumbnail_small_preview');
    });

    document.getElementById('additional_images').addEventListener('change', function(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('additional_images_preview');
        previewContainer.innerHTML = '';
        for (const file of files) {
            if (file.size > maxFileSize) {
                alert('File size exceeds 2MB limit.');
                event.target.value = ''; // Clear the input
                return;
            }
            const img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.style.width = '320px';
            img.style.height = '180px';
            img.style.objectFit = 'cover';
            img.style.objectPosition = 'top';
            img.classList.add('m-2');
            previewContainer.appendChild(img);
        }
    });
});