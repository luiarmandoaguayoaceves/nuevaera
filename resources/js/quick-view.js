document.addEventListener('DOMContentLoaded', () => {
  const items = Array.from(document.querySelectorAll('.js-quick'));
  if (items.length === 0) return;

  const modal = document.getElementById('quickView');
  const img   = document.getElementById('qvImg');
  const title = document.getElementById('qvTitle');
  const wapp  = document.getElementById('qvWapp');
  const close = document.getElementById('qvClose');
  const prev  = document.getElementById('qvPrev');
  const next  = document.getElementById('qvNext');

  let imgs = [];
  let idx = 0;
  let phone = '';
  let modelo = '';

  const setVisible = (v) => {
    if (!modal) return;
    modal.classList.toggle('hidden', !v);
    document.body.style.overflow = v ? 'hidden' : '';
  };

  const composeWappLink = (phone, modelo, imgUrl) => {
    const urlPage = location.href.split('#')[0];
    const text = `Hola, me interesa el modelo ${modelo}.\nFoto: ${imgUrl}\nPágina: ${urlPage}`;
    return `https://wa.me/${phone}?text=${encodeURIComponent(text)}`;
  };

  const loadCurrent = () => {
    const current = imgs[idx] || '';
    if (img) { img.src = current; img.alt = `Modelo ${modelo}`; }
    if (title) { title.textContent = `Modelo ${modelo}`; }
    if (wapp) { wapp.href = composeWappLink(phone, modelo, current); }
  };

  items.forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      try { imgs = JSON.parse(el.dataset.images || '[]'); } catch { imgs = []; }
      if (imgs.length === 0) imgs = [el.dataset.img || ''];
      idx = 0;
      modelo = el.dataset.model || '';
      phone  = el.dataset.whats || '';
      loadCurrent();
      setVisible(true);
    });
  });

  prev?.addEventListener('click', () => {
    if (!imgs.length) return;
    idx = (idx - 1 + imgs.length) % imgs.length;
    loadCurrent();
  });
  next?.addEventListener('click', () => {
    if (!imgs.length) return;
    idx = (idx + 1) % imgs.length;
    loadCurrent();
  });

  close?.addEventListener('click', () => setVisible(false));
  modal?.addEventListener('click', (e) => { if (e.target === modal) setVisible(false); });
  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') setVisible(false);
    if (e.key === 'ArrowLeft') prev?.click();
    if (e.key === 'ArrowRight') next?.click();
  });
});
