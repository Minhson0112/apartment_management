(() => {
  const qs = (sel, ctx = document) => ctx.querySelector(sel);
  const qsa = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));

  // Elements
  const modal = qs('#contractExtensionModal');
  const openBtn = qs('#openContractExtensionModalBtn');
  const closeBtn = qs('#closeContractExtensionModalBtn');
  const form = qs('#contractExtensionForm');
  const generalErr = qs('#contractExtensionGeneralError');
  const csrf = qs('meta[name="csrf-token"]')?.getAttribute('content');

  const clearSingleFieldError = (el) => {
    if (!el) return;
    el.classList.remove('is-invalid');
    el.removeAttribute('aria-invalid');
    const next = el.nextElementSibling;
    if (next && next.classList.contains('field-error')) next.remove();
  };

  const clearFieldErrors = (ctx = form) => {
    if (generalErr) {
      generalErr.style.display = 'none';
      generalErr.textContent = '';
    }
    qsa('.field-error', ctx).forEach((n) => n.remove());
    qsa('.is-invalid', ctx).forEach((el) => {
      el.classList.remove('is-invalid');
      el.removeAttribute('aria-invalid');
    });
  };

  const setFieldError = (name, messages) => {
    const input = qs(`[name="${name}"]`, form);
    if (!input) return;
    const msg = Array.isArray(messages) ? messages[0] : String(messages);
    input.classList.add('is-invalid');
    input.setAttribute('aria-invalid', 'true');
    const p = document.createElement('p');
    p.className = 'field-error';
    p.textContent = msg;
    input.insertAdjacentElement('afterend', p);
  };

  // ----- Open / Close modal -----
  const openModal = () => {
    clearFieldErrors();
    form?.reset();
    modal?.classList.add('active');
    modal?.setAttribute('aria-hidden', 'false');
  };
  const closeModal = () => {
    modal?.classList.remove('active');
    modal?.setAttribute('aria-hidden', 'true');
  };

  openBtn?.addEventListener('click', openModal);
  closeBtn?.addEventListener('click', closeModal);
  qsa('#contractExtensionModal [data-close-modal]').forEach((el) => el.addEventListener('click', closeModal));
  modal?.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-backdrop')) closeModal();
  });
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal?.classList.contains('active')) closeModal();
  });

  // Gắn auto-clear khi user sửa
  qsa('input,select,textarea', form).forEach((el) => {
    el.addEventListener('input', () => clearSingleFieldError(el));
    el.addEventListener('change', () => clearSingleFieldError(el));
  });

  // ----- Submit handler -----
  form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const action = form.getAttribute('action');
    if (!action) return;

    const submitBtn = qs('.modal-footer .btn.primary', form);
    const origBtnText = submitBtn ? submitBtn.textContent : '';
    submitBtn && ((submitBtn.disabled = true), (submitBtn.textContent = 'Đang lưu...'));

    clearFieldErrors();

    const fd = new FormData(form);

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

      // Nếu server trả HTML (redirect), reload để đồng bộ
      if (!ct.includes('application/json')) {
        window.location.reload();
        return;
      }

      const payload = await res.json();

      if (!res.ok) {
        // 422 validation
        if (payload && payload.errors) {
          Object.entries(payload.errors).forEach(([field, msgs]) => {
            setFieldError(field, msgs);
          });
          return;
        }
        // Lỗi khác
        if (generalErr) {
          generalErr.textContent = payload?.message || 'Có lỗi xảy ra';
          generalErr.style.display = 'block';
        }
        return;
      }

      // Thành công
      alert('Gia hạn hợp đồng thành công!');
      window.location.reload();
    } catch (err) {
      console.error(err);
      if (generalErr) {
        generalErr.textContent = 'Không thể kết nối máy chủ. Vui lòng thử lại.';
        generalErr.style.display = 'block';
      }
    } finally {
      submitBtn && ((submitBtn.disabled = false), (submitBtn.textContent = origBtnText));
    }
  });
})();
