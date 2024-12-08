document.getElementById('thumbnail_large_path').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('thumbnail_large_preview').src = URL.createObjectURL(file);
        document.getElementById('thumbnail_large_preview').style.display = 'block';
    }
});

document.getElementById('thumbnail_small_path').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('thumbnail_small_preview').src = URL.createObjectURL(file);
        document.getElementById('thumbnail_small_preview').style.display = 'block';
    }
});

document.getElementById('additional_images').addEventListener('change', function(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('additional_images_preview');
    previewContainer.innerHTML = '';
    for (const file of files) {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.style.width = '320px';
        img.style.height = '180px';
        img.classList.add('m-2');
        previewContainer.appendChild(img);
    }
});