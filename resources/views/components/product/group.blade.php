@props(['product'])

@php
  $p = $product;
  $principal = $p->images->firstWhere('is_primary', true) ?? $p->images->sortBy('orden')->first();
  $categoria = $p->category->nombre ?? '';
  $tallasCsv = implode(',', $p->tallas ?? []);
@endphp

<section class="product-group"
         data-modelo="{{ strtolower($p->modelo) }}"
         data-nombre="{{ strtolower($p->nombre) }}"
         data-categoria="{{ strtolower($categoria) }}"
         data-tallas="{{ $tallasCsv }}">

  {{-- Encabezado elegante --}}
  <header class="mb-5 flex items-center gap-4">
    <div class="relative w-16 h-16 rounded-xl overflow-hidden bg-gray-100 border">
      @if($principal)
        <img src="{{ $principal->url }}" alt="{{ $principal->alt ?? $p->nombre }}" class="w-full h-full object-cover" loading="lazy">
      @else
        <div class="w-full h-full grid place-items-center text-xs text-gray-500">No img</div>
      @endif
    </div>

    <div class="min-w-0">
      <h3 class="text-lg md:text-xl font-semibold text-gray-900 truncate">
        <span class="text-gray-500">{{ $p->modelo }}</span> — {{ $p->nombre }}
      </h3>
      <div class="mt-1 flex flex-wrap items-center gap-2 text-sm">
        @if($categoria)
          <span class="inline-flex items-center rounded-full border border-gray-200 px-2 py-0.5 text-gray-700 bg-white"> {{ $categoria }} </span>
        @endif

        @if(!empty($p->badge))
          <span class="inline-flex items-center rounded-full bg-rose-50 text-rose-700 px-2 py-0.5 border border-rose-100">
            {{ $p->badge }}
          </span>
        @endif

        @if(!is_null($p->precio))
          <span class="ml-auto text-gray-900 font-semibold"> ${{ number_format($p->precio, 2) }} </span>
        @endif
      </div>
    </div>
  </header>

  {{-- Miniaturas (todas las imágenes del producto) --}}
  @if($p->images->isNotEmpty())
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
      @foreach($p->images->sortBy('orden') as $img)
        <button type="button"
                class="group block rounded-2xl overflow-hidden border border-gray-200 bg-white shadow-sm hover:shadow-lg transition"
                data-lightbox
                data-group="product-{{ $p->id }}"
                data-title="{{ $img->alt ?? $p->nombre }}"
                data-img="{{ $img->url }}"
                data-modelo="{{ $p->modelo }}"
                data-nombre="{{ $p->nombre }}">
          <div class="relative">
            <img src="{{ $img->url }}"
                 alt="{{ $img->alt ?? $p->nombre }}"
                 loading="lazy"
                 class="w-full h-48 object-cover transition group-hover:scale-[1.02]">
            {{-- Overlay sutil --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-black/0 to-transparent opacity-0 group-hover:opacity-100 transition"></div>
            {{-- Marca principal --}}
            @if($img->is_primary)
              <span class="absolute top-2 left-2 rounded-full bg-black/70 text-white text-[10px] px-2 py-0.5">Principal</span>
            @endif
            {{-- Lupa --}}
            <span class="absolute bottom-2 right-2 rounded-full bg-white/90 shadow px-2 py-1 text-xs font-medium opacity-0 group-hover:opacity-100 transition">
              Ver
            </span>
          </div>
        </button>
      @endforeach
    </div>
  @else
    <div class="rounded-2xl border border-gray-200 bg-white p-6 text-sm text-gray-600">
      Este producto aún no tiene imágenes.
    </div>
  @endif

  {{-- Chips de tallas (solo visual) --}}
  @if(!empty($p->tallas))
    <div class="mt-4 flex flex-wrap gap-2">
      @foreach($p->tallas as $t)
        <span class="talla-chip inline-flex items-center rounded-full border border-gray-200 bg-white px-2.5 py-1 text-xs text-gray-700">T{{ $t }}</span>
      @endforeach
    </div>
  @endif
</section>
