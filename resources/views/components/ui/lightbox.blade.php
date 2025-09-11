@push('modals')
<div id="lightbox" class="fixed inset-0 hidden z-50 bg-black/80">
  <button id="lbClose"
          class="absolute top-4 right-4 rounded-full bg-black/50 p-2 text-white text-2xl hover:bg-black/60"
          aria-label="Cerrar">&times;</button>
  <div class="h-full w-full grid grid-rows-[1fr_auto_auto] place-items-center p-4">
    <img id="lbImg" src="" alt="Vista ampliada" class="max-h-[75vh] max-w-[90vw] rounded-xl shadow-2xl object-contain">
    <p id="lbTitle" class="mt-3 text-white text-sm"></p>
    <div class="mt-3 flex items-center gap-3">
      <button id="lbPrev" class="hidden rounded-lg bg-white/10 px-3 py-2 text-white hover:bg-white/20">← Anterior</button>
      <button id="lbNext" class="hidden rounded-lg bg-white/10 px-3 py-2 text-white hover:bg-white/20">Siguiente →</button>
      <a id="lbWapp" target="_blank"
         class="rounded-lg bg-green-500 px-3 py-2 text-white font-semibold hover:bg-green-600">
        Cotizar por WhatsApp
      </a>
      <button id="lbCloseBtn" class="rounded-lg bg-gray-500 px-3 py-2 text-white hover:bg-gray-600">Cerrar</button>
    </div>
  </div>
</div>
@endpush

