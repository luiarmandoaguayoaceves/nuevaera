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
  <section id="galeria" class="py-14">
    <div class="mx-auto max-w-7xl px-4">
      <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
          <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">Colección</h2>
          <p class="text-gray-600 mt-1">Hecho en México 🇲🇽 • Envíos a todo el país</p>
        </div>
        {{-- Filtros (client-side) --}}
        <form id="filters" class="grid grid-cols-2 md:flex gap-2">
          <input id="q" type="text" placeholder="Buscar modelo o color…"
                 class="col-span-2 md:col-span-1 rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm placeholder:text-gray-400 focus:border-gray-900 focus:ring-0">
          <select id="cat" class="rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm">
            <option value="">Categoría</option>
            @foreach($categorias as $c)
              <option value="{{ $c }}">{{ ucfirst($c) }}</option>
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

      {{-- GRID --}}
      <ul id="grid" class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($productos as $p)
          <x-product.card :product="$p" />
        @endforeach
      </ul>

      {{-- Paginación server-side (opcional, si quieres en vez de “cargar más”) --}}
      <div class="mt-10">
        {{ $productos->onEachSide(1)->links() }}
      </div>
    </div>
  </section>

  {{-- Nosotros / Contacto simples (puedes extraer a parciales si quieres) --}}
  <section id="nosotros" class="bg-gray-50 py-16">
    <div class="mx-auto max-w-3xl px-4 text-center">
      <h2 class="text-2xl font-bold mb-3">Sobre nosotros</h2>
      <p>Fabricamos calzado para dama con materiales de alta calidad, pensado para el día a día y ocasiones especiales.</p>
    </div>
  </section>

  <section id="contacto" class="py-16">
    <div class="mx-auto max-w-3xl px-4 text-center">
      <h2 class="text-2xl font-bold mb-4">Contacto</h2>
      <p class="mb-2">Teléfono: <a href="tel:+521234567890" class="text-rose-500">+52 123 456 7890</a></p>
      <p class="mb-2">Correo: <a href="mailto:info@nuevaera.com" class="text-rose-500">info@nuevaera.com</a></p>
      <p>Dirección: Calle Ejemplo 123, Ciudad, México</p>
    </div>
  </section>

  {{-- Lightbox --}}
  <x-ui.lightbox />
@endsection
