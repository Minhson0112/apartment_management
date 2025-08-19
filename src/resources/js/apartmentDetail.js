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

  // Helpers
  const toast = (msg, type = 'success') => {
    const t = document.createElement('div');
    t.textContent = msg;
    Object.assign(t.style, {
      position: 'fixed',
      right: '16px',
      bottom: '16px',
      padding: '10px 14px',
      borderRadius: '10px',
      color: '#e6ebf3',
      border: '1px solid rgba(255,255,255,.1)',
      boxShadow: '0 10px 30px rgba(0,0,0,.25)',
      zIndex: 9999,
      background:
        type === 'error'
          ? 'linear-gradient(180deg,#7f1d1d,#581c1c)'
          : 'linear-gradient(180deg,#14532d,#064e3b)',
    });
    document.body.appendChild(t);
    setTimeout(() => t.remove(), 2200);
  };

  const formatMoney = (n) => {
    if (n === null || n === undefined || n === '') return '';
    const num = Number(n);
    if (Number.isNaN(num)) return String(n);
    return num.toLocaleString('vi-VN') + ' đ';
  };

  const formatArea = (n) => {
    if (n === null || n === undefined || n === '') return '';
    const num = Number(n);
    if (Number.isNaN(num)) return String(n);
    return num.toFixed(1) + ' m²';
  };

  const setText = (sel, text) => {
    const el = qs(sel);
    if (el) el.textContent = text ?? '';
  };

  // YouTube helper (đồng bộ với blade helper)
  const getYoutubeEmbed = (url) => {
    if (!url) return null;
    const m1 = url.match(/youtu\.be\/([A-Za-z0-9_-]{6,})/);
    if (m1) return `https://www.youtube.com/embed/${m1[1]}`;
    const m2 = url.match(/[?&]v=([A-Za-z0-9_-]{6,})/);
    if (m2) return `https://www.youtube.com/embed/${m2[1]}`;
    return null;
  };

  const updateVideoSection = (youtubeUrl) => {
    const embed = getYoutubeEmbed(youtubeUrl);
    const section = [...qsa('.card')].find((c) =>
      c.querySelector('.card-title')?.textContent?.includes('Video'),
    );
    if (!section) return;

    // clear content area below title
    const oldWrap = section.querySelector('.video-wrap');
    const oldPh = section.querySelector('.placeholder');

    if (embed) {
      if (oldPh) oldPh.remove();
      if (oldWrap) {
        const iframe = oldWrap.querySelector('iframe');
        if (iframe) iframe.src = embed;
      } else {
        const wrap = document.createElement('div');
        wrap.className = 'video-wrap';
        wrap.innerHTML = `<iframe width="100%" height="340" src="${embed}" frameborder="0" allowfullscreen></iframe>`;
        section.appendChild(wrap);
      }
    } else {
      if (oldWrap) oldWrap.remove();
      if (!oldPh) {
        const ph = document.createElement('div');
        ph.className = 'placeholder';
        ph.textContent = 'Chưa có video YouTube.';
        section.appendChild(ph);
      }
    }
  };

  // Build / show validation errors inside modal
  const showErrors = (errors) => {
    // remove old
    qsa('.alert.error', form).forEach((e) => e.remove());

    const ul = document.createElement('ul');
    for (const k in errors) {
      const arr = Array.isArray(errors[k]) ? errors[k] : [errors[k]];
      arr.forEach((msg) => {
        const li = document.createElement('li');
        li.textContent = msg;
        ul.appendChild(li);
      });
    }
    const box = document.createElement('div');
    box.className = 'alert error';
    box.appendChild(ul);
    // put near footer
    const footer = qs('.modal-footer', form);
    form.insertBefore(box, footer || form.lastChild);
  };

  // Submit handler (Fetch)
  form?.addEventListener('submit', async (e) => {
    e.preventDefault();

    const action = form.getAttribute('action');
    if (!action) return;

    const submitBtn = qs('.modal-footer .btn.primary', form);
    const origBtnText = submitBtn ? submitBtn.textContent : '';
    submitBtn && ((submitBtn.disabled = true), (submitBtn.textContent = 'Đang lưu...'));

    // Cleanup old errors
    qsa('.alert.error', form).forEach((e) => e.remove());

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

      // If server returns JSON (recommended)
      if (ct.includes('application/json')) {
        const payload = await res.json();

        if (!res.ok) {
          // Laravel validation error => 422 with errors
          if (payload && payload.errors) {
            showErrors(payload.errors);
            throw new Error('Validation failed');
          }
          throw new Error(payload?.message || 'Có lỗi xảy ra');
        }

        const a = payload.apartment || {};
        // Update UI fields
        if ('apartment_name' in a) setText('#v_apartment_name', a.apartment_name);
        if ('area' in a) setText('#v_area', formatArea(a.area));
        if ('toilet_count' in a) setText('#v_toilet', a.toilet_count);
        if ('appliances_price' in a) setText('#v_appliances', formatMoney(a.appliances_price));
        if ('rent_price' in a) setText('#v_rent', formatMoney(a.rent_price));
        if ('rent_start_time' in a) setText('#v_rent_start', a.rent_start_time);
        if ('rent_end_time' in a) setText('#v_rent_end', a.rent_end_time);
        if ('apartment_owner' in a) setText('#v_owner', a.apartment_owner);
        if ('note' in a) setText('#v_note', a.note || '—');

        // Enum labels: dùng server nếu có, fallback theo option đang chọn trong form
        if ('type_label' in a) {
          setText('#v_type', a.type_label);
        } else {
          const opt = qs('#type option:checked', form);
          if (opt) setText('#v_type', opt.textContent.trim());
        }
        if ('balcony_label' in a) {
          setText('#v_balcony', a.balcony_label);
        } else {
          const opt = qs('#balcony_direction option:checked', form);
          if (opt) setText('#v_balcony', opt.textContent.trim());
        }

        // YouTube
        if ('youtube_url' in a) updateVideoSection(a.youtube_url);

        closeModal();
        toast('Đã lưu thay đổi');
      } else {
        // If controller trả về redirect/html => reload để đồng bộ
        window.location.reload();
      }
    } catch (err) {
      console.error(err);
      if (!qs('.alert.error', form)) toast('Lỗi lưu dữ liệu', 'error');
    } finally {
      submitBtn && ((submitBtn.disabled = false), (submitBtn.textContent = origBtnText));
    }
  });
})();
