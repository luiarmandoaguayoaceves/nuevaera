@extends('layouts.app')

@section('title','Galería | Calzado Nueva Era')

@php
  // WhatsApp en formato internacional sin símbolos
  $whats = '523331986670';
@endphp

@section('content')
  {{-- Hero con overlay y CTA --}}
  <x-gallery.hero />

  {{-- Galería --}}
  <section id="galeria" class="py-14">
    <div class="mx-auto max-w-7xl px-4">

      {{-- Título + filtros --}}
      <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div>
          <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-gray-900">Colección</h2>
          <p class="text-gray-600 mt-1">Hecho en México 🇲🇽 • Envíos a todo el país</p>
        </div>

        <x-gallery.filters :categorias="$categorias" :tallas="$tallas" />
      </div>

      {{-- Grupos por producto --}}
      <div id="products" class="mt-10 space-y-12">
        @forelse($productos as $p)
          <x-product.group :product="$p" />
        @empty
          <div class="rounded-2xl border border-gray-200 bg-white p-6 text-sm text-gray-600">
            No hay productos activos por ahora.
          </div>
        @endforelse
      </div>

      {{-- Paginación --}}
      <div class="mt-10">
        {{ $productos->onEachSide(1)->links() }}
      </div>
    </div>
  </section>

  {{-- Secciones informativas --}}
  <section id="nosotros" class="bg-gray-50 py-16">
    <div class="mx-auto max-w-3xl px-4 text-center">
      <h2 class="text-2xl font-bold mb-3">Sobre nosotros</h2>
      <p>Fabricamos calzado para dama con materiales de alta calidad, pensado para el día a día y ocasiones especiales.</p>
    </div>
  </section>

  <section id="contacto" class="py-16">
    <div class="mx-auto max-w-3xl px-4 text-center">
      <h2 class="text-2xl font-bold mb-4">Contacto</h2>
      <p class="mb-2">Teléfono: <a href="tel:+523331986670" class="text-rose-600 hover:text-rose-700">+52 333 198 6670</a></p>
      <p class="mb-2">Correo: <a href="mailto:nuevaera2009@live.com.mx" class="text-rose-600 hover:text-rose-700">nuevaera2009@live.com.mx</a></p>
      <p>Dirección: Guadalajara Jalisco México</p>
    </div>
  </section>

  {{-- Lightbox global --}}
  <x-ui.lightbox :whats="$whats" />
@endsection

{{-- Carga el JS de galería (Vite) --}}
@push('scripts')
  @vite('resources/js/gallery.js')
@endpush
