@push('modals')
<div id="quickView" class="fixed inset-0 hidden z-50 bg-black/70">
  <div class="flex min-h-full items-center justify-center p-4">
    <div class="relative w-full max-w-md rounded-xl bg-white p-4">
      <button id="qvClose" class="absolute top-3 right-3 text-gray-600 text-2xl leading-none" aria-label="Cerrar">&times;</button>
      <img id="qvImg" src="" alt="Vista rápida" class="mx-auto max-h-80 w-full object-contain rounded" />
      <p id="qvTitle" class="mt-4 text-center text-sm text-gray-700"></p>
      <a id="qvWapp" target="_blank" class="mt-4 block rounded-lg bg-green-500 px-4 py-2 text-center text-white font-semibold hover:bg-green-600">
        Pedir por WhatsApp
      </a>
    </div>
  </div>
</div>
@endpush
