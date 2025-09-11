document.addEventListener('DOMContentLoaded', () => {
  const items = Array.from(document.querySelectorAll('.js-quick'));
  if (items.length === 0) return;

  const modal = document.getElementById('quickView');
  const img   = document.getElementById('qvImg');
  const title = document.getElementById('qvTitle');
  const wapp  = document.getElementById('qvWapp');
  const close = document.getElementById('qvClose');

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

  items.forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      const imgUrl = el.dataset.img || '';
      const modelo = el.dataset.model || '';
      const phone  = el.dataset.whats || '';
      if (img) { img.src = imgUrl; img.alt = `Modelo ${modelo}`; }
      if (title) { title.textContent = `Modelo ${modelo}`; }
      if (wapp) { wapp.href = composeWappLink(phone, modelo, imgUrl); }
      setVisible(true);
    });
  });

  close?.addEventListener('click', () => setVisible(false));
  modal?.addEventListener('click', (e) => { if (e.target === modal) setVisible(false); });
  window.addEventListener('keydown', (e) => { if (e.key === 'Escape') setVisible(false); });
});
