document.querySelectorAll('.copy-link').forEach(el => {
    el.addEventListener('click', async (e) => {
      e.preventDefault(); // chặn mở link

      const url = el.getAttribute('data-url');
      try {
        await navigator.clipboard.writeText(url);
        alert('Đã copy URL vào bộ nhớ tạm!');
      } catch (err) {
        console.error('Copy failed', err);
        alert('Không thể copy, vui lòng thử lại.');
      }
    });
  });

document.getElementById('show-add-modal').addEventListener('click', function () {
  document.getElementById('add-apartment-modal').style.display = 'flex';
});

// Đóng modal
document.getElementById('cancel-apartment-modal').addEventListener('click', function () {
  document.getElementById('add-apartment-modal').style.display = 'none';
  clearFileListApt();
  clearErrorsApt();
});

// Drop area
const dropAreaApt = document.getElementById('drop-area-apt');
const imagesInputApt = document.getElementById('images-apt');
const fileListApt = document.getElementById('file-list-apt');

function updateFileListApt(files) {
  fileListApt.innerHTML = '';
  Array.from(files).forEach((file) => {
    const li = document.createElement('li');
    li.textContent = file.name;
    fileListApt.appendChild(li);
  });
}
function clearFileListApt() {
  fileListApt.innerHTML = '';
  imagesInputApt.value = null;
}

['dragenter', 'dragover'].forEach((ev) => {
  dropAreaApt.addEventListener(ev, (e) => {
    e.preventDefault();
    dropAreaApt.classList.add('highlight');
  });
});
['dragleave', 'drop'].forEach((ev) => {
  dropAreaApt.addEventListener(ev, (e) => {
    e.preventDefault();
    dropAreaApt.classList.remove('highlight');
  });
});
dropAreaApt.addEventListener('drop', (e) => {
  const files = e.dataTransfer.files;
  imagesInputApt.files = files;
  updateFileListApt(files);
});
imagesInputApt.addEventListener('change', (e) => {
  updateFileListApt(e.target.files);
});

// Submit form
const formApt = document.getElementById('add-apartment-form');

formApt.addEventListener('submit', async (e) => {
  e.preventDefault();

  const submitBtn = formApt.querySelector('button[type="submit"]');
  submitBtn.disabled = true;
  clearErrorsApt();

  const url = formApt.action;
  const formData = new FormData(formApt);

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
        showValidationErrorsApt(data.errors);
      } else {
        alert(data.message || 'Có lỗi xảy ra. Vui lòng thử lại.');
      }
      return;
    }

    alert(data.message || 'Thêm căn hộ thành công.');
    location.reload();
  } catch (err) {
    console.error(err);
    alert('Không thể kết nối server.');
  } finally {
    submitBtn.disabled = false;
  }
});

function clearErrorsApt() {
  formApt.querySelectorAll('.error-text').forEach((e) => e.remove());
  formApt.querySelectorAll('.is-invalid').forEach((el) => el.classList.remove('is-invalid'));
}
function showValidationErrorsApt(errors) {
  Object.entries(errors).forEach(([field, msgs]) => {
    const input =
      formApt.querySelector(`[name="${field}"]`) || formApt.querySelector(`[name="${field}[]"]`);
    const group = input?.closest('.form-group') || formApt;

    if (input) input.classList.add('is-invalid');

    const err = document.createElement('div');
    err.className = 'error-text';
    err.style.color = 'red';
    err.style.fontSize = '0.9rem';
    err.textContent = msgs[0] || 'Dữ liệu không hợp lệ.';
    group.appendChild(err);
  });
}
