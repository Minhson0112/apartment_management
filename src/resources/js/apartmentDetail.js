(() => {
  const qs = (sel, ctx = document) => ctx.querySelector(sel);
  const qsa = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

  // Elements
  const modal = qs('#editModal');
  const openBtn = qs('#openEditModalBtn');
  const closeBtn = qs('#closeEditModalBtn');
  const form = qs('#editForm');
  const csrf = qs('meta[name="csrf-token"]')?.getAttribute('content');

  // Open / Close modal
  const openModal = () => {
    clearFieldErrors();
    modal?.classList.add('active');
    modal?.setAttribute('aria-hidden', 'false');
  };
  const closeModal = () => {
    modal?.classList.remove('active');
    modal?.setAttribute('aria-hidden', 'true');
  };

  openBtn?.addEventListener('click', openModal);
  closeBtn?.addEventListener('click', closeModal);
  qsa('[data-close-modal]').forEach((el) => el.addEventListener('click', closeModal));
  modal?.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-backdrop')) closeModal();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeModal();
  });

  // ----- Field error helpers -----
  const clearSingleFieldError = (el) => {
    if (!el) return;
    el.classList.remove('is-invalid');
    el.removeAttribute('aria-invalid');
    const next = el.nextElementSibling;
    if (next && next.classList.contains('field-error')) next.remove();
  };

  const clearFieldErrors = (ctx = form) => {
    qsa('.field-error', ctx).forEach((n) => n.remove());
    qsa('.is-invalid', ctx).forEach((el) => {
      el.classList.remove('is-invalid');
      el.removeAttribute('aria-invalid');
    });
  };

  const setFieldError = (name, messages) => {
    const input = qs(`[name="${name}"]`, form); // tên field đều là đơn giản: apartment_name, area, ...
    if (!input) return;
    const msg = Array.isArray(messages) ? messages[0] : String(messages);
    input.classList.add('is-invalid');
    input.setAttribute('aria-invalid', 'true');
    // Chèn p.field-error ngay sau input/select/textarea
    const p = document.createElement('p');
    p.className = 'field-error';
    p.textContent = msg;
    input.insertAdjacentElement('afterend', p);
  };

  // Gắn auto-clear khi người dùng sửa lại
  const attachCleanup = () => {
    qsa('input,select,textarea', form).forEach((el) => {
      el.addEventListener('input', () => clearSingleFieldError(el));
      el.addEventListener('change', () => clearSingleFieldError(el));
    });
  };
  attachCleanup();

  // Submit handler (Fetch)
  form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const action = form.getAttribute('action');
    if (!action) return;

    const submitBtn = qs('.modal-footer .btn.primary', form);
    const origBtnText = submitBtn ? submitBtn.textContent : '';
    submitBtn && ((submitBtn.disabled = true), (submitBtn.textContent = 'Đang lưu...'));

    // Cleanup old errors
    clearFieldErrors();

    const fd = new FormData(form);
    if (!fd.has('_method')) fd.append('_method', 'PUT');

    try {
      const res = await fetch(action, {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': csrf || '',
          Accept: 'application/json',
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: fd,
      });

      const ct = res.headers.get('content-type') || '';
      if (!ct.includes('application/json')) {
        window.location.reload();
        return;
      }

      const payload = await res.json();

      if (!res.ok) {
        // Validation 422: payload.errors = { field: [msg] }
        if (payload && payload.errors) {
          Object.entries(payload.errors).forEach(([field, msgs]) => {
            setFieldError(field, msgs);
          });
          // Không reload, giữ modal mở để user sửa
          return;
        }

        // Lỗi khác
        throw new Error(payload?.message || 'Có lỗi xảy ra');
      }
      // Thành công: chỉ cần reload để đồng bộ mọi thứ
      alert('Cập nhật thành công!');
      window.location.reload();
    } catch (err) {
      console.error(err);
    } finally {
      submitBtn && ((submitBtn.disabled = false), (submitBtn.textContent = origBtnText));
    }
  });
})();
