@push('modals')
<div id="quickView" class="fixed inset-0 hidden z-50 bg-black/70">
  <div class="flex min-h-full items-center justify-center p-4">
    <div class="relative w-full max-w-md rounded-xl bg-white p-4">
      <button id="qvClose" class="absolute top-3 right-3 text-gray-600 text-2xl leading-none" aria-label="Cerrar">&times;</button>
      <div class="relative">
        <button id="qvPrev" class="absolute left-2 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white">&larr;</button>
        <img id="qvImg" src="" alt="Vista rápida" class="mx-auto max-h-80 w-full object-contain rounded" />
        <button id="qvNext" class="absolute right-2 top-1/2 -translate-y-1/2 rounded-full bg-black/50 p-2 text-white">&rarr;</button>
      </div>
      <p id="qvTitle" class="mt-4 text-center text-sm text-gray-700"></p>
      <a id="qvWapp" target="_blank" class="mt-4 block rounded-lg bg-green-500 px-4 py-2 text-center text-white font-semibold hover:bg-green-600">
        Pedir por WhatsApp
      </a>
    </div>
  </div>
</div>
@endpush
