document.addEventListener('DOMContentLoaded', () => {
  // --------- Filtros ----------
  const $q   = document.getElementById('q');
  const $cat = document.getElementById('cat');
  const $size= document.getElementById('size');
  const groups = Array.from(document.querySelectorAll('.product-group'));
  const norm = (s) => (s || '').toString().trim().toLowerCase();

  function matchGroup(g) {
    const q   = norm($q?.value);
    const cat = norm($cat?.value);
    const sz  = norm($size?.value);

    const modelo   = g.dataset.modelo || '';
    const nombre   = g.dataset.nombre || '';
    const categoria= g.dataset.categoria || '';
    const tallasCsv= (g.dataset.tallas || '').toString();

    const okQ   = !q || modelo.includes(q) || nombre.includes(q);
    const okCat = !cat || categoria === cat;
    const okSz  = !sz || (',' + tallasCsv + ',').includes(',' + sz + ',');

    return okQ && okCat && okSz;
  }

  function applyFilters() {
    groups.forEach(g => { g.style.display = matchGroup(g) ? '' : 'none'; });
  }

  [$q,$cat,$size].forEach(el => {
    if (!el) return;
    el.addEventListener('input', applyFilters);
    el.addEventListener('change', applyFilters);
  });

  // --------- Lightbox ----------
  const items = Array.from(document.querySelectorAll('[data-lightbox]'));
  if (items.length === 0) return;

  // agrupar por producto
  const map = {};
  items.forEach(el => {
    const g = el.dataset.group || 'default';
    (map[g] ||= []).push(el);
  });

  const lb       = document.getElementById('lb');
  const backdrop = lb?.children?.[0];
  const figure   = lb?.querySelector('figure');
  const lbImg    = document.getElementById('lbImg');
  const lbTitle  = document.getElementById('lbTitle');
  const lbWapp   = document.getElementById('lbWapp');
  const lbClose  = document.getElementById('lbClose');
  const lbPrev   = document.getElementById('lbPrev');
  const lbNext   = document.getElementById('lbNext');
  const storePhone = lb?.dataset?.whats || '';

  let gKey = null, idx = 0;

  const setVisible = (v) => {
    if (!lb || !backdrop || !figure) return;
    if (v) {
      lb.classList.remove('hidden');
      requestAnimationFrame(() => {
        backdrop.classList.remove('opacity-0');
        figure.classList.remove('opacity-0','scale-95');
      });
      document.body.style.overflow = 'hidden';
    } else {
      backdrop.classList.add('opacity-0');
      figure.classList.add('opacity-0','scale-95');
      setTimeout(() => lb.classList.add('hidden'), 180);
      document.body.style.overflow = '';
    }
  };

  const composeWappLink = (modelo, nombre, imgUrl) => {
    const urlPage = location.href.split('#')[0];
    const text = `Hola, me interesa el modelo ${modelo} (${nombre}).\nFoto: ${imgUrl}\nPágina: ${urlPage}`;
    return `https://wa.me/${storePhone}?text=${encodeURIComponent(text)}`;
  };

  const loadCurrent = () => {
    const arr = map[gKey]; if (!arr) return;
    const el  = arr[idx];
    const img = el.dataset.img;
    const title = el.dataset.title || `${el.dataset.modelo} — ${el.dataset.nombre}`;
    if (lbImg) { lbImg.src = img; lbImg.alt = title; }
    if (lbTitle) lbTitle.textContent = title;
    if (lbWapp) lbWapp.href = composeWappLink(el.dataset.modelo || '', el.dataset.nombre || '', img);

    // preload vecino
    [idx-1, idx+1].forEach(i => {
      const n = (i + arr.length) % arr.length;
      const pre = new Image(); pre.src = arr[n].dataset.img;
    });
  };

  const open = (group, i) => { gKey = group; idx = i; loadCurrent(); setVisible(true); };
  const move = (delta) => { const arr = map[gKey]; if (!arr) return; idx = (idx + delta + arr.length) % arr.length; loadCurrent(); };

  items.forEach(el => el.addEventListener('click', () => {
    const g = el.dataset.group || 'default';
    open(g, map[g].indexOf(el));
  }));

  lbClose?.addEventListener('click', () => setVisible(false));
  lbPrev?.addEventListener('click', () => move(-1));
  lbNext?.addEventListener('click', () => move(1));
  backdrop?.addEventListener('click', () => setVisible(false));

  window.addEventListener('keydown', (e) => {
    if (lb?.classList.contains('hidden')) return;
    if (e.key === 'Escape') setVisible(false);
    if (e.key === 'ArrowLeft') move(-1);
    if (e.key === 'ArrowRight') move(1);
  });

  // Gestos mobile
  let sx = 0, sy = 0;
  lb?.addEventListener('touchstart', (e) => { sx = e.touches[0].clientX; sy = e.touches[0].clientY; }, {passive:true});
  lb?.addEventListener('touchend', (e) => {
    const dx = (e.changedTouches[0].clientX - sx);
    const dy = Math.abs(e.changedTouches[0].clientY - sy);
    if (Math.abs(dx) > 40 && dy < 80) move(dx > 0 ? -1 : 1);
  }, {passive:true});
});
