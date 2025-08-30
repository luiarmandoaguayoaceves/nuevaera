@push('modals')
<div id="lightbox" class="fixed inset-0 hidden z-50 bg-black/80">
  <button class="absolute top-4 right-4 text-white text-3xl" aria-label="Cerrar" id="lbClose">&times;</button>
  <div class="h-full w-full grid grid-rows-[1fr_auto] place-items-center p-4">
    <img id="lbImg" src="" alt="Vista ampliada" class="max-h-[75vh] max-w-[90vw] rounded-xl shadow-2xl object-contain">
    <div class="mt-3 flex items-center gap-3">
      <button id="prev" class="rounded-lg bg-white/10 px-3 py-2 text-white hover:bg-white/20">← Anterior</button>
      <button id="next" class="rounded-lg bg-white/10 px-3 py-2 text-white hover:bg-white/20">Siguiente →</button>
      <a id="waBtn" target="_blank"
         class="rounded-lg bg-green-500 px-3 py-2 text-white font-semibold hover:bg-green-600">
        Cotizar por WhatsApp
      </a>
    </div>
  </div>
</div>
@endpush

