// Hiện modal
document.getElementById('show-add-modal').addEventListener('click', function () {
  document.getElementById('add-customer-modal').style.display = 'flex';
});

// Cancel modal
document.getElementById('cancel-modal').addEventListener('click', function () {
  document.getElementById('add-customer-modal').style.display = 'none';
  clearFileList();
});

// Drop area
const dropArea = document.getElementById('drop-area');
const imagesInput = document.getElementById('images');
const fileList = document.getElementById('file-list');

function updateFileList(files) {
  fileList.innerHTML = '';
  Array.from(files).forEach((file) => {
    const li = document.createElement('li');
    li.textContent = file.name;
    fileList.appendChild(li);
  });
}

function clearFileList() {
  fileList.innerHTML = '';
  imagesInput.value = null;
}

['dragenter', 'dragover'].forEach((eventName) => {
  dropArea.addEventListener(eventName, (e) => {
    e.preventDefault();
    dropArea.classList.add('highlight');
  });
});
['dragleave', 'drop'].forEach((eventName) => {
  dropArea.addEventListener(eventName, (e) => {
    e.preventDefault();
    dropArea.classList.remove('highlight');
  });
});
dropArea.addEventListener('drop', (e) => {
  e.preventDefault();
  const files = e.dataTransfer.files;
  imagesInput.files = files;
  updateFileList(files);
});

// Input change
imagesInput.addEventListener('change', (e) => {
  updateFileList(e.target.files);
});

// Submit form
const form = document.getElementById('add-customer-form');

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  const submitBtn = form.querySelector('button[type="submit"]');
  submitBtn.disabled = true;
  clearErrors();

  const url = form.action;
  const formData = new FormData(form);

  try {
    const res = await fetch(url, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        Accept: 'application/json',
      },
      credentials: 'same-origin',
      body: formData,
    });

    const data = await res.json().catch(() => ({}));

    if (!res.ok) {
      if (res.status === 422 && data.errors) {
        showValidationErrors(data.errors);
      } else {
        alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
      }
      return;
    }

    // success
    alert(data.message || 'Thêm khách hàng thành công');
    location.reload();
  } catch (err) {
    console.error(err);
    alert('Không thể kết nối server.');
  } finally {
    submitBtn.disabled = false;
  }
});

function clearErrors() {
  form.querySelectorAll('.error-text').forEach((e) => e.remove());
  form.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
}

function showValidationErrors(errors) {
  Object.entries(errors).forEach(([field, msgs]) => {
    const input =
      form.querySelector(`[name="${field}"]`) || form.querySelector(`[name="${field}[]"]`);
    const group = input?.closest('.form-group') || form;

    if (input) input.classList.add('is-invalid');

    const err = document.createElement('div');
    err.className = 'error-text';
    err.style.color = 'red';
    err.style.fontSize = '0.9rem';
    err.textContent = msgs[0] || 'Dữ liệu không hợp lệ.';
    group.appendChild(err);
  });
}
