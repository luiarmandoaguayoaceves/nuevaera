// Filtros en cliente y Quick View
const grid = document.getElementById('grid');
const filters = document.getElementById('filters');
const q = document.getElementById('q');
const cat = document.getElementById('cat');
const size = document.getElementById('size');

function applyFilters() {
  const term = (q?.value || '').trim().toLowerCase();
  const c = cat?.value || '';
  const s = size?.value || '';
  // Oculta/Muestra en base a dataset de cada card
  grid.querySelectorAll('li').forEach(li => {
    const model = (li.querySelector('.js-quick')?.dataset.model || '').toLowerCase();
    const catText = (li.querySelector('p.text-xs')?.textContent || '').trim().toLowerCase();
    const tallas = [...li.querySelectorAll('[data-talla]')].map(el => el.dataset.talla);
    const okQ = !term || model.includes(term);
    const okC = !c   || catText === c;
    const okS = !s   || tallas.includes(String(parseInt(s)));
    li.style.display = (okQ && okC && okS) ? '' : 'none';
  });
}

// Lightbox
const lb = document.getElementById('lightbox');
const lbImg = document.getElementById('lbImg');
const lbClose = document.getElementById('lbClose');
const prevBtn = document.getElementById('prev');
const nextBtn = document.getElementById('next');
const waBtn = document.getElementById('waBtn');
let items = [];
let idx = 0;

function hydrateItems() {
  items = [...grid.querySelectorAll('.js-quick')].map(a => ({
    img: a.dataset.img,
    modelo: a.dataset.model,
    precio: parseFloat(a.dataset.precio || '0'),
    wa: a.dataset.whats || ''
  }));
  // marcar tallas con data-talla para filtros
  grid.querySelectorAll('li').forEach(li => {
    li.querySelectorAll('.talla-pill').forEach(p => p.setAttribute('data-talla', p.textContent.replace('T','')));
  });
}

function openLB(i) {
  idx = i;
  const p = items[idx];
  lbImg.src = p.img;
  const msg = `Hola, me interesa el Modelo ${p.modelo}`;
  if (p.wa) waBtn.href = `https://wa.me/${p.wa}?text=${encodeURIComponent(msg)}`;
  lb.classList.remove('hidden');
}
function closeLB(){ lb.classList.add('hidden'); }
function prev(){ if (idx>0) openLB(idx-1); }
function next(){ if (idx<items.length-1) openLB(idx+1); }

function attachEvents() {
  grid.addEventListener('click', e => {
    const a = e.target.closest('.js-quick');
    if (!a) return;
    e.preventDefault();
    hydrateItems();
    const list = [...grid.querySelectorAll('.js-quick')];
    openLB(list.indexOf(a));
  });
  filters?.addEventListener('input', applyFilters);
  lbClose?.addEventListener('click', closeLB);
  lb?.addEventListener('click', e => { if (e.target === lb) closeLB(); });
  prevBtn?.addEventListener('click', prev);
  nextBtn?.addEventListener('click', next);
  window.addEventListener('keydown', e => {
    if (lb.classList.contains('hidden')) return;
    if (e.key === 'Escape') closeLB();
    if (e.key === 'ArrowLeft') prev();
    if (e.key === 'ArrowRight') next();
  });
}

document.addEventListener('DOMContentLoaded', () => {
  // usa document directamente
  document.querySelectorAll('.talla-pill').forEach(el => {
    el.setAttribute('data-talla', el.textContent.replace('T', ''));
  });

  // solo si Wn existe
  if (typeof window.Wn === 'function') {
    window.Wn();
  }
});

