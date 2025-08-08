document.getElementById('show-add-modal').addEventListener('click', function() {
    document.getElementById('add-owner-modal').style.display = 'flex';
});

// Cancel modal
document.getElementById('cancel-modal').addEventListener('click', function() {
    document.getElementById('add-owner-modal').style.display = 'none';
    clearFileList();
});

// Drop area
const dropArea = document.getElementById('drop-area');
const imagesInput = document.getElementById('images');
const fileList = document.getElementById('file-list');

function updateFileList(files) {
    fileList.innerHTML = '';
    Array.from(files).forEach(file => {
        const li = document.createElement('li');
        li.textContent = file.name;
        fileList.appendChild(li);
    });
}

function clearFileList() {
    fileList.innerHTML = '';
    imagesInput.value = null;
}

['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropArea.classList.add('highlight');
    });
});
['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropArea.classList.remove('highlight');
    });
});
dropArea.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    imagesInput.files = files;
    updateFileList(files);
});

// Input change
imagesInput.addEventListener('change', (e) => {
    updateFileList(e.target.files);
});

// Submit form
document.getElementById('add-owner-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    fetch("{{ route('owner.store') }}", {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // handle success
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
