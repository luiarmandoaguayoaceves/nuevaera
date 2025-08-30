@props(['whats' => null])

<div id="lb" class="fixed inset-0 z-[60] hidden" data-whats="{{ $whats }}">
  <div class="absolute inset-0 bg-black/75 backdrop-blur-sm opacity-0 transition-opacity duration-200"></div>

  <div class="absolute inset-0 flex items-center justify-center p-4">
    <div class="relative max-w-6xl w-full">
      {{-- cerrar --}}
      <button id="lbClose"
              class="absolute -top-10 right-0 md:top-0 md:-right-10 rounded-full bg-white/90 hover:bg-white shadow p-2"
              aria-label="Cerrar">✕</button>

      {{-- prev/next --}}
      <button id="lbPrev"
              class="hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 -translate-x-12 rounded-full bg-white/90 hover:bg-white shadow w-11 h-11 items-center justify-center text-xl"
              aria-label="Anterior">‹</button>
      <button id="lbNext"
              class="hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 translate-x-12 rounded-full bg-white/90 hover:bg-white shadow w-11 h-11 items-center justify-center text-xl"
              aria-label="Siguiente">›</button>

      <figure class="rounded-2xl overflow-hidden bg-white shadow-2xl transform scale-95 opacity-0 transition duration-200">
        <img id="lbImg" src="" alt="" class="max-h-[70vh] w-full object-contain bg-black/5">
        <figcaption class="flex flex-wrap items-center justify-between gap-2 px-4 py-3 text-sm text-gray-700">
          <span id="lbTitle" class="font-medium"></span>
          <a id="lbWapp" href="#" target="_blank" rel="noopener"
             class="inline-flex items-center gap-2 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5">
            {{-- Icono --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" class="w-4 h-4 fill-current"><path d="M19.11 17.05a.86.86 0 0 1-.61-.28l-1.23-1.34a.86.86 0 0 1 .05-1.2c.45-.41.8-.92 1-1.49.12-.34 0-.73-.29-.93l-1.16-.82a.94.94 0 0 0-1.26.2 6.53 6.53 0 0 0-1.35 2.69c-.34 1.5.02 3.1.98 4.31a6.22 6.22 0 0 0 4.48 2.4c.74.04 1.47-.06 2.17-.31.63-.22 1.2-.58 1.68-1.05a.95.95 0 0 0 .03-1.31l-.92-1.01a.92.92 0 0 0-1.2-.16c-.61.4-1.32.62-2.05.66z"/><path d="M27.9 14.95a11.94 11.94 0 0 1-18.2 9.95L5 26.86l1.98-4.43a12 12 0 1 1 20.92-7.48zm-11.95 10a9.98 9.98 0 1 0-8.65-4.97l.2.35-1.09 2.45 2.54-1 .33.2a9.9 9.9 0 0 0 6.67 1.97z"/></svg>
            WhatsApp
          </a>
        </figcaption>
      </figure>
    </div>
  </div>
</div>
