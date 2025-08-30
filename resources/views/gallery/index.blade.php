@extends('layouts.app')

@section('title','Galería | Calzado Nueva Era')

@section('content')
  {{-- Hero --}}
  <section id="inicio" class="relative grid place-items-center h-[50vh]">
    <img src="{{ asset('img/portada.webp') }}" alt="Colección Nueva Era" class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 px-4 text-center text-white">
      <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight">Calzado Nueva Era</h1>
      <p class="mt-3 max-w-xl mx-auto text-white/90">Calidad, comodidad y estilo para cada día.</p>
      <div class="mt-6">
        <a href="#galeria" class="rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow hover:bg-gray-100">Ver galería</a>
      </div>
    </div>
  </section>

  {{-- Galería --}}
  @php
    // ← Ajusta aquí tu número de WhatsApp en formato internacional sin signos
    $whats = '523331986670'; // +52 333 198 6670
  @endphp

  <section id="galeria" class="py-14">
    <div class="mx-auto max-w-7xl px-4">
      <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
          <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">Colección</h2>
          <p class="text-gray-600 mt-1">Hecho en México 🇲🇽 • Envíos a todo el país</p>
        </div>

        {{-- Filtros (client-side) --}}
        <form id="filters" class="grid grid-cols-2 md:flex gap-2">
          <input id="q" type="text" placeholder="Buscar modelo o nombre…"
                 class="col-span-2 md:col-span-1 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-gray-900 focus:ring-0">
          <select id="cat" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm">
            <option value="">Categoría</option>
            @foreach($categorias as $c)
              @php $label = is_object($c) ? $c->nombre : $c; @endphp
              <option value="{{ $label }}">{{ ucfirst($label) }}</option>
            @endforeach
          </select>
          <select id="size" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm">
            <option value="">Talla</option>
            @foreach($tallas as $t)
              <option>{{ $t }}</option>
            @endforeach
          </select>
        </form>
      </div>

      {{-- Grupos por producto --}}
      <div id="products" class="mt-10 space-y-12">
        @forelse($productos as $p)
          @php
            $principal = $p->images->firstWhere('is_primary', true) ?? $p->images->sortBy('orden')->first();
            $categoria = $p->category->nombre ?? '';
            $tallasCsv = implode(',', $p->tallas ?? []);
          @endphp

          <section
            class="product-group"
            data-modelo="{{ strtolower($p->modelo) }}"
            data-nombre="{{ strtolower($p->nombre) }}"
            data-categoria="{{ strtolower($categoria) }}"
            data-tallas="{{ $tallasCsv }}"
          >
            {{-- Encabezado del producto --}}
            <header class="mb-4 flex items-center gap-4">
              <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 border">
                @if($principal)
                  <img src="{{ $principal->url }}" alt="{{ $principal->alt ?? $p->nombre }}"
                       class="w-full h-full object-cover" loading="lazy">
                @endif
              </div>
              <div>
                <h3 class="text-lg font-semibold">{{ $p->modelo }} — {{ $p->nombre }}</h3>
                <p class="text-sm text-gray-500">
                  {{ $categoria ?: 'Sin categoría' }}
                  @if(!empty($p->badge))
                    • <span class="inline-block rounded-full bg-gray-900 text-white text-[11px] px-2 py-0.5">{{ $p->badge }}</span>
                  @endif
                </p>
              </div>
            </header>

            {{-- Grid de imágenes del producto --}}
            @if($p->images->isNotEmpty())
              <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach($p->images->sortBy('orden') as $img)
                  <button type="button"
                          class="group block rounded-2xl overflow-hidden border bg-white shadow-sm hover:shadow-md transition"
                          data-lightbox
                          data-group="product-{{ $p->id }}"
                          data-title="{{ $img->alt ?? $p->nombre }}"
                          data-img="{{ $img->url }}"
                          data-modelo="{{ $p->modelo }}"
                          data-nombre="{{ $p->nombre }}">
                    <div class="relative">
                      <img src="{{ $img->url }}"
                           alt="{{ $img->alt ?? $p->nombre }}"
                           class="w-full h-48 object-cover transition group-hover:scale-[1.02]">
                      @if($img->is_primary)
                        <span class="absolute top-2 left-2 rounded-full bg-black/70 text-white text-[10px] px-2 py-0.5">Principal</span>
                      @endif
                    </div>
                  </button>
                @endforeach
              </div>
            @else
              <div class="rounded-xl border bg-white p-6 text-sm text-gray-500">
                Este producto aún no tiene imágenes.
              </div>
            @endif
          </section>
        @empty
          <div class="rounded-xl border bg-white p-6">No hay productos activos por ahora.</div>
        @endforelse
      </div>

      {{-- Paginación --}}
      <div class="mt-10">
        {{ $productos->onEachSide(1)->links() }}
      </div>
    </div>
  </section>

  {{-- Nosotros / Contacto --}}
  <section id="nosotros" class="bg-gray-50 py-16">
    <div class="mx-auto max-w-3xl px-4 text-center">
      <h2 class="text-2xl font-bold mb-3">Sobre nosotros</h2>
      <p>Fabricamos calzado para dama con materiales de alta calidad, pensado para el día a día y ocasiones especiales.</p>
    </div>
  </section>

  <section id="contacto" class="py-16">
    <div class="mx-auto max-w-3xl px-4 text-center">
      <h2 class="text-2xl font-bold mb-4">Contacto</h2>
      <p class="mb-2">Teléfono: <a href="tel:+523331986670" class="text-rose-500">+52 333 198 6670</a></p>
      <p class="mb-2">Correo: <a href="mailto:nuevaera2009@live.com.mx" class="text-rose-500">nuevaera2009@live.com.mx</a></p>
      <p>Dirección: Guadalajara Jalisco México</p>
    </div>
  </section>

  {{-- MODAL / LIGHTBOX --}}
  <div id="lb" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/75 backdrop-blur-sm opacity-0 transition-opacity duration-200"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
      <div class="relative max-w-6xl w-full">
        {{-- botón cerrar --}}
        <button id="lbClose"
                class="absolute -top-10 right-0 md:top-0 md:-right-10 rounded-full bg-white/90 hover:bg-white shadow p-2"
                aria-label="Cerrar">
          ✕
        </button>

        {{-- Botones anterior/siguiente --}}
        <button id="lbPrev"
                class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-12 rounded-full bg-white/90 hover:bg-white shadow w-11 h-11 items-center justify-center text-xl"
                aria-label="Anterior">‹</button>
        <button id="lbNext"
                class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-12 rounded-full bg-white/90 hover:bg-white shadow w-11 h-11 items-center justify-center text-xl"
                aria-label="Siguiente">›</button>

        {{-- Contenedor imagen --}}
        <figure class="rounded-2xl overflow-hidden bg-white shadow-2xl transform scale-95 opacity-0 transition duration-200">
          <img id="lbImg" src="" alt="" class="max-h-[70vh] w-full object-contain bg-black/5">
          <figcaption id="lbCap" class="flex flex-wrap items-center justify-between gap-2 px-4 py-3 text-sm text-gray-700">
            <span id="lbTitle" class="font-medium"></span>
            {{-- Botón WhatsApp --}}
            <a id="lbWapp"
               href="#"
               target="_blank"
               rel="noopener"
               class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5">
              {{-- icono WA "simple" --}}
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-4 h-4 fill-current"><path d="M19.11 17.05a.86.86 0 0 1-.61-.28l-1.23-1.34a.86.86 0 0 1 .05-1.2c.45-.41.8-.92 1-1.49.12-.34 0-.73-.29-.93l-1.16-.82a.94.94 0 0 0-1.26.2 6.53 6.53 0 0 0-1.35 2.69c-.34 1.5.02 3.1.98 4.31a6.22 6.22 0 0 0 4.48 2.4c.74.04 1.47-.06 2.17-.31.63-.22 1.2-.58 1.68-1.05a.95.95 0 0 0 .03-1.31l-.92-1.01a.92.92 0 0 0-1.2-.16c-.61.4-1.32.62-2.05.66z"/><path d="M27.9 14.95a11.94 11.94 0 0 1-18.2 9.95L5 26.86l1.98-4.43a12 12 0 1 1 20.92-7.48zm-11.95 10a9.98 9.98 0 1 0-8.65-4.97l.2.35-1.09 2.45 2.54-1 .33.2a9.9 9.9 0 0 0 6.67 1.97z"/></svg>
              WhatsApp
            </a>
          </figcaption>
        </figure>
      </div>
    </div>
  </div>

  {{-- LÓGICA: filtros + lightbox --}}
  <script>
    (function () {
      // ---------- Filtros ----------
      const $q   = document.getElementById('q');
      const $cat = document.getElementById('cat');
      const $size= document.getElementById('size');
      const groups = Array.from(document.querySelectorAll('.product-group'));

      function norm(s){ return (s||'').toString().trim().toLowerCase(); }

      function matchGroup(g) {
        const q   = norm($q.value);
        const cat = norm($cat.value);
        const sz  = norm($size.value);

        const modelo = g.dataset.modelo || '';
        const nombre = g.dataset.nombre || '';
        const categoria = g.dataset.categoria || '';
        const tallasCsv = (g.dataset.tallas || '').toString();

        const okQ   = !q || modelo.includes(q) || nombre.includes(q);
        const okCat = !cat || categoria === cat;
        const okSz  = !sz || (','+tallasCsv+',').includes(','+sz+',');

        return okQ && okCat && okSz;
      }

      function applyFilters() {
        groups.forEach(g => g.style.display = matchGroup(g) ? '' : 'none');
      }

      [$q,$cat,$size].forEach(el => el && el.addEventListener('input', applyFilters));
      [$cat,$size].forEach(el => el && el.addEventListener('change', applyFilters));

      // ---------- Lightbox ----------
      const items = Array.from(document.querySelectorAll('[data-lightbox]'));
      if (items.length === 0) return;

      // Agrupa por producto
      const map = {};
      items.forEach(el => {
        const g = el.dataset.group || 'default';
        (map[g] ||= []).push(el);
      });

      const lb      = document.getElementById('lb');
      const backdrop= lb.children[0];
      const figure  = lb.querySelector('figure');
      const lbImg   = document.getElementById('lbImg');
      const lbTitle = document.getElementById('lbTitle');
      const lbWapp  = document.getElementById('lbWapp');
      const closeBt = document.getElementById('lbClose');
      const prevBt  = document.getElementById('lbPrev');
      const nextBt  = document.getElementById('lbNext');

      const storePhone = "{{ $whats }}"; // whatsapp destino

      let gKey = null, idx = 0;

      function setVisible(v) {
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
      }

      function composeWappLink(modelo, nombre, imgUrl) {
        const urlPage = location.href.split('#')[0];
        const text = `Hola, me interesa el modelo ${modelo} (${nombre}).\nFoto: ${imgUrl}\nPágina: ${urlPage}`;
        return `https://wa.me/${storePhone}?text=${encodeURIComponent(text)}`;
      }

      function loadCurrent() {
        const arr = map[gKey]; if (!arr) return;
        const el  = arr[idx];
        const img = el.dataset.img;
        const title = el.dataset.title || `${el.dataset.modelo} — ${el.dataset.nombre}`;
        lbImg.src = img;
        lbImg.alt = title;
        lbTitle.textContent = title;
        lbWapp.href = composeWappLink(el.dataset.modelo || '', el.dataset.nombre || '', img);
        // preload vecinos
        [idx-1, idx+1].forEach(i => {
          const n = (i + arr.length) % arr.length;
          const pre = new Image(); pre.src = arr[n].dataset.img;
        });
      }

      function open(group, i) {
        gKey = group; idx = i;
        loadCurrent();
        setVisible(true);
      }

      function move(delta) {
        const arr = map[gKey]; if (!arr) return;
        idx = (idx + delta + arr.length) % arr.length;
        loadCurrent();
      }

      // Bind miniaturas
      items.forEach(el => el.addEventListener('click', () => {
        const g = el.dataset.group || 'default';
        open(g, map[g].indexOf(el));
      }));

      // Controles
      closeBt.addEventListener('click', () => setVisible(false));
      prevBt.addEventListener('click', () => move(-1));
      nextBt.addEventListener('click', () => move(1));
      backdrop.addEventListener('click', () => setVisible(false));

      // Teclado
      window.addEventListener('keydown', (e) => {
        if (lb.classList.contains('hidden')) return;
        if (e.key === 'Escape') setVisible(false);
        if (e.key === 'ArrowLeft') move(-1);
        if (e.key === 'ArrowRight') move(1);
      });

      // Gestos (simple) para móvil
      let sx = 0, sy = 0;
      lb.addEventListener('touchstart', (e) => { sx = e.touches[0].clientX; sy = e.touches[0].clientY; }, {passive:true});
      lb.addEventListener('touchend', (e) => {
        const dx = (e.changedTouches[0].clientX - sx);
        const dy = Math.abs(e.changedTouches[0].clientY - sy);
        if (Math.abs(dx) > 40 && dy < 80) move(dx > 0 ? -1 : 1);
      }, {passive:true});
    })();
  </script>
@endsection
