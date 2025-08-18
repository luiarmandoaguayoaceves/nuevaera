@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-b from-white to-gray-50">
  <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
      <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Colección de Calzado</h1>
        <p class="mt-2 text-gray-600">Comodidad, calidad y estilo. Hecho en México 🇲🇽</p>
      </div>
      <p class="text-sm text-gray-500">
        Mostrando <b>{{ $productos->count() }}</b> de <b>{{ $total }}</b>
      </p>
    </div>

    <!-- Filtros -->
    <form method="GET" class="mt-6 grid gap-3 sm:grid-cols-12">
      <div class="sm:col-span-6">
        <label class="sr-only" for="q">Buscar</label>
        <div class="relative">
          <input id="q" name="q" value="{{ $q }}"
                 type="text" placeholder="Buscar modelo, color o tipo…"
                 class="w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-2.5 pr-10 shadow-sm placeholder:text-gray-400 focus:border-gray-900 focus:ring-0">
          <svg class="pointer-events-none absolute right-3 top-2.5 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 111.414-1.414l3.387 3.387a1 1 0 01-1.414 1.414l-3.387-3.387zM14 8a6 6 0 11-12 0 6 6 0 0112 0z" clip-rule="evenodd"/>
          </svg>
        </div>
      </div>

      <div class="sm:col-span-3">
        <label class="sr-only" for="categoria">Categoría</label>
        <select id="categoria" name="categoria"
                class="w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-0">
          <option value="">Todas las categorías</option>
          @foreach($categorias as $c)
            <option value="{{ $c }}" @selected($categoria===$c)>{{ ucfirst($c) }}</option>
          @endforeach
        </select>
      </div>

      <div class="sm:col-span-3">
        <label class="sr-only" for="talla">Talla</label>
        <select id="talla" name="talla"
                class="w-full rounded-xl border border-gray-200 bg-white/80 px-4 py-2.5 shadow-sm focus:border-gray-900 focus:ring-0">
          <option value="">Todas las tallas</option>
          @foreach($tallas as $t)
            <option value="{{ $t }}" @selected($talla==(string)$t)">Talla {{ $t }}</option>
          @endforeach
        </select>
      </div>

      <div class="sm:col-span-12 flex items-center gap-2">
        <button class="rounded-xl bg-black px-4 py-2 text-sm font-semibold text-white shadow hover:bg-gray-900">Aplicar</button>
        <a href="{{ route('galeria') }}" class="rounded-xl border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-900">Limpiar</a>
      </div>
    </form>

    <!-- Grid -->
    <ul role="list" class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
      @forelse($productos as $p)
        @php
          // Imagen principal (ajusta según tu modelo/relación)
          $img = $p->imagen_url
              ?? optional($p->imagenes->first())->url
              ?? asset('img/placeholder.webp');

          // Etiqueta opcional (ej. $p->badge)
          $badge = $p->badge ?? null;

          // Precio opcional
          $precio = $p->precio ?? null;

          // Texto para WhatsApp
          $waNumber = $wa;
          $waText = rawurlencode("Hola, me interesa el Modelo {$p->modelo}. ¿Podrías darme información de tallas, colores y precio?");
          $waLink = $waNumber ? "https://wa.me/{$waNumber}?text={$waText}" : '#';
        @endphp

        <li class="group relative overflow-hidden rounded-2xl bg-white ring-1 ring-gray-200/70 shadow-sm transition hover:shadow-lg hover:-translate-y-0.5">
          <a href="{{ $waLink }}" target="_blank" rel="noopener" class="block" aria-label="Modelo {{ $p->modelo }} - solicitar cotización">
            <div class="relative aspect-[3/4] w-full overflow-hidden bg-gray-100">
              <div class="absolute inset-0 animate-pulse bg-gray-200"></div>
              <img
                src="{{ $img }}"
                alt="Modelo {{ $p->modelo }} - Calzado para dama"
                loading="lazy" decoding="async"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                onload="this.previousElementSibling?.remove()"
              />
              @if($badge)
                <span class="absolute left-3 top-3 rounded-full bg-black/80 px-3 py-1 text-xs font-semibold text-white shadow">
                  {{ $badge }}
                </span>
              @endif
            </div>
          </a>

          <div class="space-y-1 p-4">
            <div class="flex items-start justify-between gap-3">
              <h3 class="text-sm font-semibold text-gray-900">Modelo {{ $p->modelo }}</h3>
              @if(!is_null($precio))
                <p class="text-sm font-bold text-gray-900">${{ number_format($precio, 2) }} MXN</p>
              @endif
            </div>
            @if(!empty($p->categoria))
              <p class="text-xs text-gray-500 capitalize">{{ $p->categoria }}</p>
            @endif

            <div class="mt-3 flex items-center gap-2">
              <a href="{{ $waLink }}" target="_blank" rel="noopener"
                 class="inline-flex items-center justify-center rounded-xl bg-black px-3 py-2 text-xs font-semibold text-white shadow hover:bg-gray-900">
                WhatsApp cotización
              </a>
              @if(route_has('productos.show') ?? false)
                <a href="{{ route('productos.show', $p) }}"
                   class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-900 hover:border-gray-300">
                  Ver detalles
                </a>
              @endif
            </div>
          </div>
        </li>
      @empty
        <li class="col-span-full">
          <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center text-gray-500">
            No encontramos productos con esos filtros.
          </div>
        </li>
      @endforelse
    </ul>

    <!-- Paginación -->
    <div class="mt-10">
      {{ $productos->onEachSide(1)->links() }}
    </div>
  </div>
</section>
@endsection
