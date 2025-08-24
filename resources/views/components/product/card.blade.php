@props([
  'product', // App\Models\Product con ->imagen_principal, ->images, ->category
])

@php
  $img   = $product->imagen_principal ?? asset('img/placeholder.webp');
  $precio = $product->precio;
  $badge  = $product->badge;
  $modelo = $product->modelo;
  $catStr = $product->category->slug ?? $product->category->nombre ?? ($product->categoria ?? '');
  $tallas = is_array($product->tallas ?? null) ? $product->tallas : [];
@endphp

<li
  class="group relative overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200/70 shadow-sm transition hover:shadow-lg hover:-translate-y-0.5">
  <a href="#"
     class="block js-quick"
     data-model="{{ $modelo }}"
     data-img="{{ $img }}"
     data-precio="{{ $precio ?? 0 }}"
     data-whats="{{ config('services.whatsapp_sales') }}">
    <div class="relative aspect-[3/4] w-full overflow-hidden bg-gray-100">
      <div class="absolute inset-0 animate-pulse bg-gray-200"></div>
      <img src="{{ $img }}" alt="Modelo {{ $modelo }} - Calzado"
           loading="lazy" decoding="async"
           class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
           onload="this.previousElementSibling?.remove()">
      @if($badge)
        <span class="absolute left-3 top-3 rounded-full bg-black/80 px-3 py-1 text-xs font-semibold text-white shadow">
          {{ $badge }}
        </span>
      @endif
      <button type="button"
        class="absolute bottom-3 left-1/2 -translate-x-1/2 rounded-xl bg-white/90 px-3 py-1.5 text-sm font-semibold text-gray-900 shadow opacity-0 backdrop-blur transition group-hover:opacity-100 hover:bg-white">
        Vista rápida
      </button>
    </div>
  </a>

  <div class="space-y-1 p-4">
    <div class="flex items-start justify-between gap-3">
      <h3 class="text-sm font-semibold text-gray-900">Modelo {{ $modelo }}</h3>
      @if(!is_null($precio))
        {{-- <p class="text-sm font-bold text-gray-900">${{ number_format($precio, 2) }} MXN</p> --}}
      @endif
    </div>
    @if($catStr)
      <p class="text-xs text-gray-500 capitalize">{{ $catStr }}</p>
    @endif
    @if(!empty($tallas))
      <div class="mt-2 flex flex-wrap gap-1.5">
        @foreach($tallas as $t)
          <span class="rounded-md border border-gray-200 px-2 py-0.5 text-[11px] text-gray-700">T{{ $t }}</span>
        @endforeach
      </div>
    @endif
  </div>
</li>
